<?php
require_once BASE_PATH . '/app/Core/DB.php';

class BikeSlider
{
    public static function allVisible(): array
    {
        $pdo = DB::connect();
        return $pdo->query("
            SELECT image, color, price_per_hour
            FROM bikes_slider
            WHERE visible = 1
            ORDER BY display_order ASC, id_slide DESC
        ")->fetchAll(PDO::FETCH_ASSOC);
    }
}