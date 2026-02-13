<?php 
class Movimiento extends Model {

    //Registrar un nuevo movimiento
    public function registrarMovimiento($data) {
        $sql = "INSERT INTO movimientos (id_usuario, tipo_movimiento, monto, fecha) VALUES (:id_usuario, :tipo_movimiento, :monto, :fecha)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_usuario', $data['id_usuario']);
        $stmt->bindParam(':tipo_movimiento', $data['tipo_movimiento']);
        $stmt->bindParam(':monto', $data['monto']);
        $stmt->bindParam(':fecha', $data['fecha']);
        return $stmt->execute();

    }

}