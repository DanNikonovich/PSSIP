<?php

class DB
{
    private static ?PDO $pdo = null;

    public static function connect(): PDO
    {
        if (self::$pdo === null) {

            $config = require_once BASE_PATH . '/config/config.php';
            $db = $config['db'];

            self::$pdo = new PDO(
                "mysql:host={$db['host']};dbname={$db['name']};charset={$db['charset']}",
                $db['user'],
                $db['pass']
            );

            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$pdo;
    }
}