<?php
namespace App\Database;
include __DIR__.'/../../vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

class DbHandler
{
    private static $db;

    public static function connect()
    {
        if (self::$db === null) {
            $localhost = $_ENV["DB_SERVERNAME"];
            $username = $_ENV["DB_USERNAME"];
            $password = $_ENV["DB_PASSWORD"];
            $dbname = $_ENV["DB_NAME"];

            self::$db = mysqli_connect($localhost, $username, $password, $dbname);

            if (self::$db->connect_error) {
                die('Erreur de connexion : ' . self::$db->connect_error);
            }
            
        }

        return self::$db;
    }

    }


