<?php
require_once BASE_PATH . '/app/Core/DB.php';

class BikeInfo
{
    public static function getVisibleBySection(string $section): array
    {
        $pdo = DB::connect();
        $stmt = $pdo->prepare("
            SELECT icon, `desc`, `value`
            FROM bike_info_items
            WHERE visible = 1 AND section = ?
            ORDER BY display_order ASC, id_item DESC
        ");
        $stmt->execute([$section]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}