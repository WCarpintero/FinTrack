<?php
require_once "MainModel.php";

class Movimientos extends MainModel {

    public function __construct() {
        parent :: __construct(); 
    }

    public function registrarMovimiento($id_usuario, $id_tipo, $id_divisa, $monto, $id_horario, $resultado, $descripcion, $fechaOperacion){
        $sql = "INSERT INTO movimientos(usuario_fk, tipo_movimiento_fk, divisa_fk, monto, horario_fk, resultado, descripcion, fecha_operacion)
                VALUES(:id_usuario, :id_tipo, :id_divisa, :monto, :id_horario, :resultado, :descripcion, :fecha_operacion)";

        $params = [
            ':id_usuario' => $id_usuario,
            ':id_tipo' => $id_tipo,
            ':id_divisa' => $id_divisa,
            ':monto' => $monto,
            ':id_horario' => $id_horario,
            ':resultado' => $resultado,
            ':descripcion' => $descripcion,
            ':fecha_operacion' => $fechaOperacion
        ];

        return $this->query($sql, $params);
    }

    public function movimientoRegistroUsuario($id_usuario, $id_tipo, $id_divisa, $monto, $id_horario, $resultado, $fechaOperacion){
        
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

    public function listarTiposMovimiento() {
        $sql = "SELECT id, nombre 
        FROM tipo_movimiento
        WHERE id != 3"; // Excluye el tipo de movimiento con id 3 (registro por defecto)
        return $this->table($sql);
    }

    //Muestra un breve historial de movimientos recientes (últimos 3 días)
    public function breveHistorial() {
        $sql = "SELECT m.id,
					CONCAT(u.nombre, u.apellido) AS usuario,
                    tm.nombre AS tipo_movimiento, 
                    d.codigo AS divisa, 
                    m.monto, 
                    h.hora AS horario, 
                    m.resultado AS utilidad, 
                    m.descripcion,
                    DATE_FORMAT(m.fecha_operacion, '%d/%m/%Y') AS operado,
                    DATE_FORMAT(m.fecha_registro, '%d/%m/%Y') AS registro
                FROM movimientos m
                INNER JOIN usuarios u ON u.id = m.usuario_fk
                INNER JOIN tipo_movimiento tm ON tm.id = m.tipo_movimiento_fk
                INNER JOIN divisas d ON d.id = m.divisa_fk
                INNER JOIN horario h ON h.id = m.horario_fk
                WHERE m.fecha_registro >= NOW() - INTERVAL 3 DAY
                ORDER BY m.fecha_registro DESC";
        return $this->table($sql);
    }
}