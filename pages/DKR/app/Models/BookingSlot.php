<?php

class BookingSlot
{
    // проверка доступности байков на выбранные слоты
    public static function canReserve(string $date, array $times, int $bikes, int $maxBikes = 4): bool
    {
        $pdo = DB::connect();

        // подготовим плейсхолдеры IN (?, ?, ?)
        $placeholders = implode(',', array_fill(0, count($times), '?'));

        $sql = "
          SELECT TIME_FORMAT(time_slot, '%H:%i') AS t, COALESCE(SUM(bikes_count),0) AS taken
          FROM booking_slots
          WHERE date_booking = ?
            AND TIME_FORMAT(time_slot, '%H:%i') IN ($placeholders)
          GROUP BY time_slot
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_merge([$date], $times));

        $takenMap = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $takenMap[$row['t']] = (int)$row['taken'];
        }

        foreach ($times as $t) {
            $taken = $takenMap[$t] ?? 0;
            if ($taken + $bikes > $maxBikes) {
                return false;
            }
        }

        return true;
    }

    // вставка слотов для брони
    public static function insertSlots(int $idBooking, string $date, array $times, int $bikes, ?PDO $pdo = null): void
    {
        $pdo = $pdo ?: DB::connect();

        $stmt = $pdo->prepare("
            INSERT INTO booking_slots (id_booking, date_booking, time_slot, bikes_count)
            VALUES (:id_booking, :date_booking, :time_slot, :bikes_count)
        ");

        foreach ($times as $t) {
            // важно: TIME в БД обычно 'HH:MM:SS'
            $timeSlot = preg_match('/:\d{2}$/', $t) ? $t . ':00' : $t;

            $stmt->execute([
                ':id_booking'   => $idBooking,
                ':date_booking' => $date,
                ':time_slot'    => $timeSlot,
                ':bikes_count'  => $bikes,
            ]);
        }
    }
}