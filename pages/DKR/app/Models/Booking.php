<?php
require_once BASE_PATH . '/app/Core/DB.php';

class Booking
{
    public static function rangeWithUsers(string $from, string $to): array
    {
        $pdo = DB::connect();
        $stmt = $pdo->prepare("
            SELECT
                b.*,
                u.name  AS user_name,
                u.phone AS user_phone,
                u.email AS user_email,
                e.title AS event_title,
                p.title AS promo_title
            FROM bookings b
            LEFT JOIN users u ON u.id_user = b.id_user
            LEFT JOIN events e ON e.id_event = b.id_event
            LEFT JOIN promos p ON p.id_promo = b.id_promo
            WHERE b.date_booking >= ? AND b.date_booking <= ?
            ORDER BY b.date_booking ASC, b.time_booking ASC
        ");
        $stmt->execute([$from, $to]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function countWeek(): int
    {
        $from = date('Y-m-d');
        $to   = date('Y-m-d', strtotime('+7 day'));

        $pdo = DB::connect();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE date_booking >= ? AND date_booking <= ?");
        $stmt->execute([$from, $to]);
        return (int)$stmt->fetchColumn();
    }
    
    public static function create(array $data, ?PDO $pdo = null): int
    {
        $pdo = $pdo ?: DB::connect();

        $stmt = $pdo->prepare("
            INSERT INTO bookings
              (date_booking, time_booking, bikes_count, payment_type,
               total_amount, paid_amount, left_amount, discount_amount,
               id_user, id_event, id_promo)
            VALUES
              (:date_booking, :time_booking, :bikes_count, :payment_type,
               :total_amount, :paid_amount, :left_amount, :discount_amount,
               :id_user, :id_event, :id_promo)
        ");

        $stmt->execute([
            ':date_booking'    => $data['date_booking'],
            ':time_booking'    => $data['time_booking'],
            ':bikes_count'     => $data['bikes_count'],
            ':payment_type'    => $data['payment_type'],

            ':total_amount'    => $data['total_amount'],
            ':paid_amount'     => $data['paid_amount'],
            ':left_amount'     => $data['left_amount'],
            ':discount_amount' => $data['discount_amount'],

            ':id_user'         => $data['id_user'],
            ':id_event'        => $data['id_event'],
            ':id_promo'        => $data['id_promo'],
        ]);

        return (int)$pdo->lastInsertId();
    }

    public static function byMonth(int $year, int $month): array
    {
        $pdo = DB::connect();
        $start = sprintf('%04d-%02d-01', $year, $month);
        $end = (new DateTime($start))->modify('first day of next month')->format('Y-m-d');
    
        $st = $pdo->prepare("
          SELECT b.*, u.name AS user_name, e.title AS event_title, p.title AS promo_title
          FROM bookings b
          LEFT JOIN users u ON u.id_user = b.id_user
          LEFT JOIN events e ON e.id_event = b.id_event
          LEFT JOIN promos p ON p.id_promo = b.id_promo
          WHERE b.date_booking >= ? AND b.date_booking < ?
          ORDER BY b.date_booking, b.time_booking
        ");
        $st->execute([$start, $end]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function betweenDates(string $start, string $end): array
    {
        $pdo = DB::connect();
        $st = $pdo->prepare("
          SELECT b.*, u.name AS user_name, e.title AS event_title, p.title AS promo_title
          FROM bookings b
          LEFT JOIN users u ON u.id_user = b.id_user
          LEFT JOIN events e ON e.id_event = b.id_event
          LEFT JOIN promos p ON p.id_promo = b.id_promo
          WHERE b.date_booking BETWEEN ? AND ?
          ORDER BY b.date_booking, b.time_booking
        ");
        $st->execute([$start, $end]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}