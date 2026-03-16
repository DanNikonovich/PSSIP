<?php

require_once BASE_PATH . '/app/Core/Controller.php';
require_once BASE_PATH . '/app/Core/DB.php';
require_once BASE_PATH . '/app/Core/Auth.php';

require_once BASE_PATH . '/app/Models/Event.php';
require_once BASE_PATH . '/app/Models/Promo.php';
require_once BASE_PATH . '/app/Models/Booking.php';
require_once BASE_PATH . '/app/Models/BookingSlot.php';

class BookingController extends Controller
{
    private const RATE = 80;       // BYN за 1 байк за 1 час
    private const MAX_BIKES = 4;

    public function form(): void
    {
        Auth::requireLogin();

        $events = Event::all();
        $promos = Promo::allActive();

        $selectedEventId = isset($_GET['event_id']) ? (int)$_GET['event_id'] : null;
        $selectedPromoId = isset($_GET['promo_id']) ? (int)$_GET['promo_id'] : null;

        $user = Auth::user();

        $this->view('booking', [
            'events' => $events,
            'promos' => $promos,
            'selectedEventId' => $selectedEventId,
            'selectedPromoId' => $selectedPromoId,
            'user' => $user
        ]);
    }

    public function store(): void
    {
        Auth::requireLogin();
        $user = Auth::user();

        $date  = trim($_POST['date_booking'] ?? '');
        $time  = trim($_POST['time_booking'] ?? ''); // "11:00,12:00"
        $bikes = (int)($_POST['bikes_count'] ?? 0);
        $pay   = trim($_POST['payment_type'] ?? '');
        $event = (int)($_POST['id_event'] ?? 0);

        $promo = $_POST['id_promo'] ?? null;
        $promo = ($promo === '' || $promo === null) ? null : (int)$promo;

        if ($date === '' || $time === '' || $bikes <= 0 || $event <= 0) {
            http_response_code(400);
            echo "Заполните дату, время, количество байков и выберите мероприятие.";
            return;
        }

        $times = array_values(array_filter(array_map('trim', explode(',', $time))));
        if (!$times) {
            http_response_code(400);
            echo "Выберите время.";
            return;
        }

        if ($bikes > self::MAX_BIKES) {
            http_response_code(400);
            echo "Можно выбрать максимум " . self::MAX_BIKES . " байка(ов).";
            return;
        }

        // защита от двойного бронирования
        if (!BookingSlot::canReserve($date, $times, $bikes, self::MAX_BIKES)) {
            http_response_code(409);
            echo "К сожалению, выбранное время уже занято для выбранного количества байков. Выберите другое время или уменьшите количество байков.";
            return;
        }

        // подтягиваем промо (если выбрано)
        $promoRow = null;
        if ($promo !== null) {
            $promoRow = Promo::findById($promo);
            if (!$promoRow) $promo = null; // если вдруг id битый
        }

        // считаем деньги на сервере (истина всегда здесь)
        $calc = $this->calcMoney([
            'bikes' => $bikes,
            'times' => $times,
            'pay'   => $pay,
            'promo' => $promoRow,
        ]);

        $pdo = DB::connect();
        $pdo->beginTransaction();

        try {
            $idBooking = Booking::create([
                'date_booking'    => $date,
                'time_booking'    => implode(',', $times),
                'bikes_count'     => $bikes,
                'payment_type'    => $pay,

                'total_amount'    => $calc['total'],
                'paid_amount'     => $calc['paid'],
                'left_amount'     => $calc['left'],
                'discount_amount' => $calc['discount'],

                'id_user'         => (int)$user['id_user'],
                'id_event'        => $event,
                'id_promo'        => $promo,
            ], $pdo); // ✅ один PDO

            BookingSlot::insertSlots($idBooking, $date, $times, $bikes, $pdo); // ✅ один PDO

            $pdo->commit();

        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            http_response_code(500);
            echo "Ошибка сохранения бронирования.";
            // error_log($e->getMessage());
            return;
        }

        // ✅ TG отправляй ПОСЛЕ commit и НЕ ломай пользователю редирект, если TG упал
        try {
            $this->sendTelegramBookingNotice((int)$user['id_user'], [
                'date'  => $date,
                'times' => $times,
                'left'  => $calc['left'],
                'name'  => $user['name'] ?? '',
            ]);
        } catch (\Throwable $e) {
            // error_log("TG error: " . $e->getMessage());
        }

        header("Location: /booking/success?id=" . $idBooking);
        exit;
    }

    public function success(): void
    {
        Auth::requireLogin();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $this->view('booking_success', ['id' => $id]);
    }

    public function getSlots(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $pdo = DB::connect();
        $date = $_GET['date'] ?? null;
        if (!$date) { echo json_encode([]); return; }

        $times = ['10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00'];

        $stmt = $pdo->prepare("
            SELECT TIME_FORMAT(time_slot, '%H:%i') AS t,
                   COALESCE(SUM(bikes_count),0) AS taken
            FROM booking_slots
            WHERE date_booking = ?
            GROUP BY time_slot
        ");
        $stmt->execute([$date]);

        $takenMap = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $takenMap[$row['t']] = (int)$row['taken'];
        }

        $out = [];
        foreach ($times as $t) {
            $taken = $takenMap[$t] ?? 0;
            $available = max(0, self::MAX_BIKES - $taken);
            $out[] = [
                'time' => $t,
                'available_bikes' => $available,
                'is_full' => ($available <= 0),
                'taken' => $taken,
            ];
        }

        echo json_encode($out);
    }

    // ---------------- helpers ----------------

    private function calcMoney(array $in): array
    {
        $bikes = (int)$in['bikes'];
        $times = $in['times'];
        $pay   = $in['pay'] ?: 'full';

        $hours = max(1, count($times));
        $baseTotal = self::RATE * $bikes * $hours;

        $discount = 0;

        // ✅ подстрой под реальные поля promos в БД:
        // варианты:
        //  - discount_percent (например 10)
        //  - discount_amount  (фикс BYN)
        $promo = $in['promo'] ?? null;
        if (is_array($promo)) {
            if (!empty($promo['discount_percent'])) {
                $discount = $baseTotal * ((float)$promo['discount_percent'] / 100);
            } elseif (!empty($promo['discount_amount'])) {
                $discount = (float)$promo['discount_amount'];
            }
        }

        $discount = max(0, min($baseTotal, $discount));
        $total = $baseTotal - $discount;

        $paid = 0;
        if ($pay === 'full') $paid = $total;
        elseif ($pay === 'part') $paid = $total * 0.30;
        else $paid = 0;

        $paid = round($paid, 2);
        $total = round($total, 2);
        $left = round(max(0, $total - $paid), 2);

        return [
            'base' => round($baseTotal, 2),
            'discount' => round($discount, 2),
            'total' => $total,
            'paid' => $paid,
            'left' => $left,
            'hours' => $hours,
        ];
    }

    private function sendTelegramBookingNotice(int $userId, array $data): void
    {
        $pdo = DB::connect();
        $stmt = $pdo->prepare("SELECT telegram_chat_id, name FROM users WHERE id_user = ? LIMIT 1");
        $stmt->execute([$userId]);
        $u = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($u['telegram_chat_id'])) return;

        $name = $u['name'] ?: ($data['name'] ?: 'друг');

        $period = $this->formatPeriod($data['times']); // "13:00 — 13:59" или "11:00 — 12:59"
        $leftToPay = number_format((float)$data['left'], 2, '.', '');

        $msg =
            "Здравствуйте, {$name}!\n\n" .
            "Напоминаем, что вы забронировали поездку на внедорожных электромотоциклах.\n" .
            "Дата: {$data['date']}\n" .
            "Время: {$period}\n" .
            "К оплате у вас осталось: {$leftToPay} BYN.\n" .
            "Возможен наличный и безналичный расчёт.\n\n" .
            "Оденьтесь поудобнее, с собой взять документ удостоверения личности.";

        $this->tgSend((int)$u['telegram_chat_id'], $msg);
    }

    private function formatPeriod(array $times): string
    {
        // times: ["11:00","12:00"] -> "11:00 — 12:59"
        sort($times);
        $start = $times[0];
        $last = $times[count($times)-1];

        $dt = \DateTime::createFromFormat('H:i', $last);
        if (!$dt) return "{$start} — {$last}";
        $dt->modify('+59 minutes');
        $end = $dt->format('H:i');

        return "{$start} — {$end}";
    }

    private function tgSend(int $chatId, string $text): void
    {
        $cfg = require BASE_PATH . '/config/telegram.php';
        $token = $cfg['bot_token'];

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'chat_id' => $chatId,
                'text' => $text,
            ]),
            CURLOPT_TIMEOUT => 10,
        ]);
        curl_exec($ch);
        curl_close($ch);
    }
}