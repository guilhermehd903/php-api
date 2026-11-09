<?php

namespace Service\Api\core;

use PDO;

class DB
{

    private static PDO|null $instance = null;


    protected static function con()
    {
        if (self::$instance == null) {
            $db = $_ENV["DATABASE_NAME"];
            $host = $_ENV["DATABASE_HOST"];
            $pwd = $_ENV["DATABASE_PWD"];
            $user = $_ENV["DATABASE_USER"];
            $drive = $_ENV["DATABASE_DRIVE"];
            $port = $_ENV["DATABASE_PORT"];

            self::$instance = new PDO(
                "{$drive}:host={$host};port={$port};dbname={$db}",
                "{$user}",
                "{$pwd}",
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]
            );
        }

        return self::$instance;
    }
}
