<?php
require_once "MainModel.php";

class Movimientos extends MainModel {

    public function __construct() {
        parent :: __construct(); 
    }

    public function registrarMovimiento($id_usuario, $id_tipo, $id_divisa, $monto, $id_horario, $resultado, $descripcion, $fechaOperacion){
        $sql = "INSERT INTO movimientos(usuario_fk, tipo_movimiento_fk, divisa_fk, monto, horario_fk, resultado, descripcion, fecha_operacion)
                VALUES(:id_usuario, :id_tipo, :id_divisa, :monto, :id_horario, :resultado, :descripcion, :fechaOperacion";

        $params = [
            ':id_usuario' => $id_usuario,
            ':id_tipo' => $id_tipo,
            ':id_divisa' => $id_divisa,
            ':monto' => $monto,
            ':id_horario' => $id_horario,
            ':resultado' => $resultado,
            ':descripcion' => $descripcion,
            ':fechaOperacion' => $fechaOperacion
        ];

        return $this->query($sql, $params);
    }

    public function movimientoRegistroUsuario($id_usuario, $id_tipo, $id_divisa, $monto, $id_horario, $resultado, $fechaOperacion){
        
        $descripcion = "Registro inicial de usuario";
        
        $sql = "INSERT INTO movimientos(usuario_fk, tipo_movimiento_fk, divisa_fk, monto, horario_fk, resultado, descripcion, fecha_operacion)
                VALUES(:id_usuario, :id_tipo, :id_divisa, :monto, :id_horario, :resultado, :descripcion, :fecha)";

        $params = [
            ':id_usuario' => $id_usuario,
            ':id_tipo' => $id_tipo,
            ':id_divisa' => $id_divisa,
            ':monto' => $monto,
            ':id_horario' => $id_horario,
            ':resultado' => $resultado,
            ':descripcion' => "Registro por defecto al crear usuario",
            ':fecha' => $fechaOperacion
        ];

        return $this->query($sql, $params);
    }
}