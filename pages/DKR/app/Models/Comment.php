<?php
require_once BASE_PATH . '/app/Core/DB.php';

class Comment
{
    public static function latestVisible(int $limit = 6): array
    {
        $pdo = DB::connect();
        $stmt = $pdo->prepare("
            SELECT 
                c.id_comment,
                c.id_user,
                c.text_review,
                c.rating,
                c.visible,
                c.date_created,
                u.name AS author_name
            FROM comments c
            LEFT JOIN users u ON u.id_user = c.id_user
            WHERE c.visible = 1
            ORDER BY c.date_created DESC
            LIMIT ?
        ");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function createPending(array $data): int
    {
        $pdo = DB::connect();

        // ⚠️ ВАЖНО: author_name в таблице comments НЕТ — сохраняем только id_user + текст + рейтинг
        $stmt = $pdo->prepare("
            INSERT INTO comments (id_user, text_review, rating, visible, date_created)
            VALUES (:id_user, :text_review, :rating, 0, NOW())
        ");

        $stmt->execute([
            ':id_user'     => (int)$data['id_user'],
            ':text_review' => (string)$data['text_review'],
            ':rating'      => (int)$data['rating'],
        ]);

        return (int)$pdo->lastInsertId();
    }

    public static function allPending(): array
    {
        $pdo = DB::connect();
        return $pdo->query("
            SELECT 
                c.id_comment,
                c.id_user,
                c.text_review,
                c.rating,
                c.visible,
                c.date_created,
                u.name AS author_name,
                u.email,
                u.phone
            FROM comments c
            LEFT JOIN users u ON u.id_user = c.id_user
            WHERE c.visible = 0
            ORDER BY c.date_created DESC
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function allPublished(int $limit = 50): array
    {
        $pdo = DB::connect();
        $stmt = $pdo->prepare("
            SELECT 
                c.id_comment,
                c.id_user,
                c.text_review,
                c.rating,
                c.visible,
                c.date_created,
                u.name AS author_name
            FROM comments c
            LEFT JOIN users u ON u.id_user = c.id_user
            WHERE c.visible = 1
            ORDER BY c.date_created DESC
            LIMIT ?
        ");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function approve(int $id): void
    {
        $pdo = DB::connect();
        $stmt = $pdo->prepare("UPDATE comments SET visible=1 WHERE id_comment=?");
        $stmt->execute([$id]);
    }

    public static function setVisible(int $id, int $visible): void
    {
        $pdo = DB::connect();
        $stmt = $pdo->prepare("UPDATE comments SET visible = ? WHERE id_comment = ?");
        $stmt->execute([$visible, $id]);
    }

    public static function deleteById(int $id): void
    {
        $pdo = DB::connect();
        $stmt = $pdo->prepare("DELETE FROM comments WHERE id_comment = ?");
        $stmt->execute([$id]);
    }

    public static function countPending(): int
    {
        $pdo = DB::connect();
        return (int)$pdo->query("SELECT COUNT(*) FROM comments WHERE visible = 0")->fetchColumn();
    }
}