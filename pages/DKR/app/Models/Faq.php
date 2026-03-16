<?php
require_once BASE_PATH . '/app/Core/DB.php';

class Faq
{
    public static function allActive(): array
    {
        $pdo = DB::connect();
        return $pdo->query("
            SELECT * FROM faq
            WHERE visible = 1
            ORDER BY display_order ASC, id_faq DESC
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function all(): array
    {
        $pdo = DB::connect();
        return $pdo->query("
            SELECT * FROM faq
            ORDER BY display_order ASC, id_faq DESC
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(string $q, string $a, int $order, int $visible): void
    {
        $pdo = DB::connect();
        $stmt = $pdo->prepare("
            INSERT INTO faq (question, answer, display_order, visible, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$q, $a, $order, $visible]);
    }

    public static function update(int $id, string $q, string $a, int $order): void
    {
        $pdo = DB::connect();
        $stmt = $pdo->prepare("
            UPDATE faq
            SET question = ?, answer = ?, display_order = ?, updated_at = NOW()
            WHERE id_faq = ?
        ");
        $stmt->execute([$q, $a, $order, $id]);
    }

    public static function deleteById(int $id): void
    {
        $pdo = DB::connect();
        $stmt = $pdo->prepare("DELETE FROM faq WHERE id_faq = ?");
        $stmt->execute([$id]);
    }

    public static function setVisible(int $id, int $visible): void
    {
        $pdo = DB::connect();
        $stmt = $pdo->prepare("UPDATE faq SET visible = ? WHERE id_faq = ?");
        $stmt->execute([$visible, $id]);
    }

    public static function countVisible(): int
    {
        $pdo = DB::connect();
        return (int)$pdo->query("SELECT COUNT(*) FROM faq WHERE visible = 1")->fetchColumn();
    }
}