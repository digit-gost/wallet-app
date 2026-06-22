<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    public static function connect(): PDO
    {
        try {
            return new PDO(
                "pgsql:host=127.0.0.1;port=5432;dbname=wallet_app",
                "postgres",
                "dig1tGost",
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die("Erreur connexion DB : " . $e->getMessage());
        }
    }
}