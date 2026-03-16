<?php

require_once BASE_PATH . '/app/Core/Controller.php';
require_once BASE_PATH . '/app/Core/Auth.php';
require_once BASE_PATH . '/app/Core/DB.php';

require_once BASE_PATH . '/app/Models/Comment.php';
require_once BASE_PATH . '/app/Models/Faq.php';
require_once BASE_PATH . '/app/Models/Booking.php';

class AdminController extends Controller
{
    private function requireAdmin(): void
    {
        Auth::requireLogin();
        $u = Auth::user();
        if (empty($u) || ($u['role'] ?? '') !== 'admin') {
            http_response_code(403);
            echo "Доступ запрещён";
            exit;
        }
    }

    public function loginForm(): void
    {
        $this->view('admin/login', [
            'error' => null
        ]);
    }

    public function login(): void
    {
        // Простой вариант: логин/пароль админа из users (role=admin)
        $email = trim($_POST['email'] ?? '');
        $pass  = trim($_POST['password'] ?? '');

        if ($email === '' || $pass === '') {
            $this->view('admin/login', ['error' => 'Введите email и пароль']);
            return;
        }

        $pdo = DB::connect();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || ($user['role'] ?? '') !== 'admin') {
            $this->view('admin/login', ['error' => 'Нет доступа']);
            return;
        }

        // если у тебя пароль в password_hash:
        if (!password_verify($pass, $user['password_hash'])) {
            $this->view('admin/login', ['error' => 'Неверный пароль']);
            return;
        }

        $_SESSION['user'] = [
            'id_user' => $user['id_user'],
            'name'    => $user['name'],
            'email'   => $user['email'],
            'role'    => $user['role'],
        ];

        header('Location: /admin');
        exit;
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        header('Location: /admin/login');
        exit;
    }

    public function dashboard(): void
    {
        $this->requireAdmin();

        $counts = [
            'pending_comments' => Comment::countPending(),
            'active_faq'       => Faq::countVisible(),
            'week_bookings'    => Booking::countWeek(),
        ];

        $this->view('admin/dashboard', [
            'counts' => $counts,
            'admin'  => Auth::user()
        ]);
    }

    // ---------- COMMENTS ----------
    public function comments(): void
    {
        $this->requireAdmin();

        $pending = Comment::allPending();
        $published = Comment::allPublished(50);

        $this->view('admin/comments', [
            'pending'   => $pending,
            'published' => $published,
            'admin'     => Auth::user()
        ]);
    }

    public function commentApprove(): void
    {
        $this->requireAdmin();
        $id = (int)($_POST['id_comment'] ?? 0);
        if ($id > 0) Comment::setVisible($id, 1);
        header('Location: /admin/comments');
        exit;
    }

    public function commentDelete(): void
    {
        $this->requireAdmin();
        $id = (int)($_POST['id_comment'] ?? 0);
        if ($id > 0) Comment::deleteById($id);
        header('Location: /admin/comments');
        exit;
    }

    // ---------- FAQ ----------
    public function faq(): void
    {
        $this->requireAdmin();

        $items = Faq::all();
        $this->view('admin/faq', [
            'items' => $items,
            'admin' => Auth::user()
        ]);
    }

    public function faqCreate(): void
    {
        $this->requireAdmin();

        $q = trim($_POST['question'] ?? '');
        $a = trim($_POST['answer'] ?? '');
        $order = (int)($_POST['display_order'] ?? 0);
        $visible = (int)($_POST['visible'] ?? 1);

        if ($q !== '' && $a !== '') {
            Faq::create($q, $a, $order, $visible);
        }

        header('Location: /admin/faq');
        exit;
    }

    public function faqUpdate(): void
    {
        $this->requireAdmin();

        $id = (int)($_POST['id_faq'] ?? 0);
        $q = trim($_POST['question'] ?? '');
        $a = trim($_POST['answer'] ?? '');
        $order = (int)($_POST['display_order'] ?? 0);

        if ($id > 0 && $q !== '' && $a !== '') {
            Faq::update($id, $q, $a, $order);
        }

        header('Location: /admin/faq');
        exit;
    }

    public function faqDelete(): void
    {
        $this->requireAdmin();
        $id = (int)($_POST['id_faq'] ?? 0);
        if ($id > 0) Faq::deleteById($id);
        header('Location: /admin/faq');
        exit;
    }

    public function faqToggle(): void
    {
        $this->requireAdmin();
        $id = (int)($_POST['id_faq'] ?? 0);
        $visible = (int)($_POST['visible'] ?? 0);
        if ($id > 0) Faq::setVisible($id, $visible);
        header('Location: /admin/faq');
        exit;
    }

    // ---------- BOOKINGS ----------
    public function bookings(): void
    {
        $this->requireAdmin();

        $from = $_GET['from'] ?? date('Y-m-d');
        $to   = $_GET['to']   ?? date('Y-m-d', strtotime('+7 day'));

        $rows = Booking::rangeWithUsers($from, $to);

        $this->view('admin/bookings', [
            'rows'  => $rows,
            'from'  => $from,
            'to'    => $to,
            'admin' => Auth::user()
        ]);
    }

    // Экспорт отчёта на неделю: Excel-friendly CSV (без кракозябр)
    public function exportWeekCsv(): void
    {
        $this->requireAdmin();

        $from = $_GET['from'] ?? date('Y-m-d');
        $to   = $_GET['to']   ?? date('Y-m-d', strtotime('+7 day'));

        $rows = Booking::rangeWithUsers($from, $to);

        $filename = "bookings_{$from}_{$to}.csv";

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="'.$filename.'"');

        // ✅ BOM для Excel (иначе русские буквы ломаются)
        echo "\xEF\xBB\xBF";

        $out = fopen('php://output', 'w');

        // ✅ Excel в RU часто нормально открывает с `;`
        $sep = ';';

        fputs($out, "Дата{$sep}Время{$sep}Байков{$sep}Оплата{$sep}Итого{$sep}Внесено{$sep}Осталось{$sep}Скидка{$sep}Мероприятие{$sep}Акция{$sep}Имя{$sep}Телефон{$sep}Email\n");

        foreach ($rows as $r) {
            $line = [
                $r['date_booking'],
                $r['time_booking'],
                $r['bikes_count'],
                $r['payment_type'],
                $r['total_amount'],
                $r['paid_amount'],
                $r['left_amount'],
                $r['discount_amount'],
                $r['event_title'] ?? '',
                $r['promo_title'] ?? '',
                $r['user_name'] ?? '',
                $r['user_phone'] ?? '',
                $r['user_email'] ?? '',
            ];
            // ручная запись с `;`
            fputs($out, implode($sep, array_map([$this,'csvEscape'], $line)) . "\n");
        }

        fclose($out);
        exit;
    }

    private function csvEscape($v): string
    {
        $s = (string)$v;
        $s = str_replace('"', '""', $s);
        return '"' . $s . '"';
    }
}