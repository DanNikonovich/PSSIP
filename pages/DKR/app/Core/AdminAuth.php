<?php

class AdminAuth
{
    public static function login(string $login, string $password): bool
    {
        $cfg = require BASE_PATH . '/config/admin.php';
        if ($login === $cfg['login'] && $password === $cfg['password']) {
            $_SESSION['is_admin'] = true;
            return true;
        }
        return false;
    }

    public static function logout(): void
    {
        unset($_SESSION['is_admin']);
    }

    public static function check(): bool
    {
        return !empty($_SESSION['is_admin']);
    }

    public static function requireAdmin(): void
    {
        if (!self::check()) {
            header("Location: /admin/login");
            exit;
        }
    }
}