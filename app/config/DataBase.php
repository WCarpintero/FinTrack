<?php
namespace app\config;

use Dotenv\Dotenv; 
use PDO;
use PDOException;

require_once __DIR__.'/../../vendor/autoload.php';

class DataBase {
    private static $instance = null;

    // El constructor puede quedar vacío o cargar el .env
    public function __construct() {
        
    }

    public function getConnection() {
        if (self::$instance === null) {
            // Cargamos variables de entorno justo antes de conectar
            $dotenv = Dotenv::createImmutable(__DIR__.'/../../');
            $dotenv->load();

            try {
                $host    = $_ENV['DB_HOST'];
                $db_name = $_ENV['DB_NAME'];
                $user    = $_ENV['DB_USER'];
                $pass    = $_ENV['DB_PASS'];
                $charset = $_ENV['DB_CHARSET'];

                $dsn = "mysql:host=$host;dbname=$db_name;charset=$charset";
                
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];

                self::$instance = new PDO($dsn, $user, $pass, $options);

            } catch(PDOException $e) {
                // En producción, es mejor loguear el error y no mostrar el die con datos sensibles
                error_log("Error de conexión: " . $e->getMessage());
                die("Error crítico de conexión al sistema financiero.");
            }
        }
        return self::$instance;
    }
}