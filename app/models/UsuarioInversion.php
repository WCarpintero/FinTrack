<?php
require_once __DIR__.'/MainModel.php';

class UsuarioInversion extends MainModel {

    public function __construct() {
        parent::__construct();
    }

    public function registrarInversion($datos) {
        $sql = "INSERT INTO inversion_usuario (usuario_fk, total_invertido_pesos, total_invertido_cripto, inicio_operaciones, par_operar_fk, regalos_bonos_cripto, saldo_actual_cripto)
                VALUES (:usuario, :pesos, :cripto, :inicio, :par, :regalos, :saldo_actual)";
        
        $params = [
            ':usuario' => $datos['usuario_id'],
            ':pesos' => $datos['monto_pesos'],
            ':cripto' => $datos['monto_cripto'],
            ':inicio' => $datos['fecha_inicio'],
            ':par' => $datos['id_par'],
            ':regalos' => $datos['regalos'],
            ':saldo_actual' => $datos['saldo_actual']
        ];

        return $this->query($sql, $params);
    }

    
    public function obtenerSaldo($id_usuario) {
        $sql = "SELECT iu.saldo_actual_cripto
                FROM inversion_usuario iu 
                INNER JOIN usuarios u ON u.id = iu.usuario_fk
                WHERE usuario_fk = :id AND u.rol_fk = :rol";

        $params = [
            ':id' => $id_usuario,
            ':rol' => 2
        ];

        return $this->row($sql, $params);
    }

    public function obtenerInicioOperaciones($id_usuario) {
        $sql = "SELECT iu.inicio_operaciones
                FROM inversion_usuario iu 
                INNER JOIN usuarios u ON u.id = iu.usuario_fk
                WHERE usuario_fk = :id  AND u.rol_fk = :rol";

        $params = [
            ':id' => $id_usuario,
            ':rol' => 2
        ];

        return $this->row($sql, $params);
    }


}