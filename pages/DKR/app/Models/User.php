<?php
require_once BASE_PATH . '/app/Core/DB.php';

class User
{
    public static function findByEmail(string $email): ?array
    {
        $pdo = DB::connect();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function create(string $name, string $email, string $phone, string $hash): int
    {
        $pdo = DB::connect();
        $stmt = $pdo->prepare("
            INSERT INTO users (name, email, phone, password_hash, role)
            VALUES (:name, :email, :phone, :hash, 'user')
        ");
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'hash' => $hash,
        ]);
        return (int)$pdo->lastInsertId();
    }
}