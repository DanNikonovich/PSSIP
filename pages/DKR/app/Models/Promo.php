<?php
require_once BASE_PATH . '/app/Core/DB.php';

class Promo
{
    public static function allActive(): array
    {
        $pdo = DB::connect();
        $stmt = $pdo->query("SELECT * FROM promos ORDER BY id_promo DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById(int $id): ?array
    {
        $pdo = DB::connect();

        $stmt = $pdo->prepare("
            SELECT *
            FROM promos
            WHERE id_promo = ?
            LIMIT 1
        ");

        $stmt->execute([$id]);

        $promo = $stmt->fetch(PDO::FETCH_ASSOC);

        return $promo ?: null;
    }

    public static function all(): array
    {
        $pdo = DB::connect();
        $stmt = $pdo->query("SELECT * FROM promos ORDER BY id_promo DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}