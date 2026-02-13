<?php
class Database {
    private $config;

    public function __construct() {
        $this->config = require __DIR__ . "/../config/database.php";
    }

    public function getConnection() {
        try {
            //Cadena DNS para la conexión PDO
           $connection = "mysql:host=" . $this->config['host'] . ";dbname=" . $this->config['db'] . ";charset=" . $this->config['charset'];
           $options = [
               PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
               PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
               PDO::ATTR_EMULATE_PREPARES => false,
           ];
           
           return new PDO($connection, $this->config['user'], $this->config['pass'], $options);

        } catch(PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
        
    }
}