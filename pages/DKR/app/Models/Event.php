<?php
require_once BASE_PATH . '/app/Core/DB.php';

class Event
{
    public static function all(): array
    {
        $pdo = DB::connect();
        $stmt = $pdo->query("SELECT id_event, title, description, image, program_points FROM events ORDER BY id_event ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}