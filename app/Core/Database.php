<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static $pdo;

    public static function connect($config)
    {
        if (self::$pdo === null) {
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$pdo = new PDO($dsn, $config['username'], $config['password'], $options);
            } catch (PDOException $e) {
                // In a real app, you would log this error and show a generic error page.
                // For development, it's okay to die and show the error.
                die('Database connection failed: ' . $e->getMessage());
            }
        }

        return self::$pdo;
    }

    public static function getPdo()
    {
        if (self::$pdo === null) {
            // This assumes connect() has been called once during app initialization.
            // You might want to add more robust handling here.
            die('Database is not connected. Call Database::connect() first.');
        }
        return self::$pdo;
    }
}
