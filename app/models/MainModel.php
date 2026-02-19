<?php
require_once __DIR__ . '/../config/DataBase.php'; 

// Importamos la clase DataBase si tiene namespace
use app\config\DataBase;

abstract class MainModel extends DataBase {

    protected $db;

    public function __construct() {
        // Llamamos al constructor de DataBase para cargar los datos del .env
        parent::__construct(); 
        
        $this->db = $this->getConnection(); 
    }

    // ---  MÉTODOS PARA TRANSACCIONES ---
    
    public function beginTransaction() {
        return $this->db->beginTransaction();
    }

    public function commit() {
        return $this->db->commit();
    }

    public function rollBack() {
        return $this->db->rollBack();
    }

    /* Funciones de operación (INSERT, UPDATE, DELETE) */
    public function query($sql, $params = null) {
        try {
            $stmt = $this->db->prepare($sql);
            $sw = $stmt->execute($params); 
        } catch (PDOException $ex) { 
           throw $ex; 
            $sw = false;
        }
        return $sw;
    }

    /* Devuelve una sola fila */
    public function row($sql, $params = null) {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            echo "ERROR ROW: " . $ex->getMessage();
            return false;
        }
    }

    /* Devuelve un array de filas */
    public function table($sql, $params = null) {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            echo "ERROR TABLE: " . $ex->getMessage();
            return array();
        }
    }

    /* Devuelve el último id insertado */
    public function getLastId() {
        return $this->db->lastInsertId(); 
    }
}