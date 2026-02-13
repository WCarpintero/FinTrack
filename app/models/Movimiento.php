<?php 
class Movimiento extends Model {

    //Registrar un nuevo movimiento
    public function registrarMovimiento($data) {
        $sql = "INSERT INTO movimientos(usuario_id_fk, tipo_movimiento_id_fk, divisa_id_fk, monto, descripcion)
                VALUES(:usuario, :tipo, :divisa, :monto, :descripcion)";

        $params = [
            ':usuario' => $data['id_usuario'],
            ':tipo' => $data['tipo_movimiento'],
            ':divisa' => $data['divisa'],
            ':monto' => $data['monto'], 
            ':descripcion' => $data['descripcion']
        ];

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    //Listar movimientos
    public function listarMovimientos(){
                    $sql = "SELECT m.id AS id_movimiento,
                    tm.nombre AS tipo_movimiento,
                    u.identificacion AS identificacion,
                    CONCAT(u.nombres, ' ', u.apellidos) AS usuario,
                    u.email,
                    u.telefono,
                    d.codigo AS divisa,
                    m.monto,
                    m.descripcion,
                    m.fecha_hora_registro
                FROM movimientos m
                INNER JOIN usuarios u ON m.usuario_id_fk = u.id
                INNER JOIN tipos_movimiento tm ON m.tipo_movimiento_id_fk = tm.id
                INNER JOIN divisas d ON m.divisa_id_fk = d.id";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    //Eliminar un registro de la tabla de movimientos
    public function eliminarMovimiento($id) {
        $sql = "DELETE FROM movimientos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

}