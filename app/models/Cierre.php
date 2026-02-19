<?php

require_once 'MainModel.php';

class Cierre extends MainModel{
    public function __construct(){
        parent::__construct();
    }

    public function generarCierreDiario($usuarioId, $fechaCierre = null) {
        // Si no se pasa fecha, asumimos que es el cierre de HOY
        $fechaCierre = $fechaCierre ?? date('Y-m-d');
        $fechaAyer = date('Y-m-d', strtotime($fechaCierre . ' -1 day'));

        try {
            // 1. Obtener la base (Cierre de ayer o Movimiento Inicial)
            // Buscar el cierre del día anterior
            $sql = "SELECT cierre_saldo FROM cierres 
                    WHERE id_usuario_fk = :id_user AND fecha = :ayer
                    LIMIT 1";

            $params = [
                ':ayer' => $fechaAyer,
                ':id_user' => $usuarioId
                ];

            $baseRes = $this->row($sql, $params);

            if ($baseRes === false) {
                // Si no hay cierre ayer, es un usuario nuevo o primer cierre (movimiento tipo 3)
                $sqlIni = "SELECT monto 
                            FROM movimientos 
                            WHERE usuario_fk = :id_user AND tipo_movimiento_fk = :tipo LIMIT 1";

                $params = [
                    ':id_user' => $usuarioId,
                    ':tipo' => 3
                ];

                $baseRes = $this->row( $sqlIni, $params );
                $base = (float) ($baseRes['monto']?? 0);
            }else{
                $base = (float) ($baseRes['cierre_saldo'] ?? 0);
            }

            // 2. Sumar utilidades de los movimientos del día de cierre
            // Importante: No sumar el movimiento inicial aquí (tipo_movimiento_fk != 3)
            $sqlUtilidad = "SELECT SUM(resultado) AS utilidad FROM movimientos 
                             WHERE usuario_fk = :id_user AND fecha_operacion = :fecha_cierre AND tipo_movimiento_fk != :tipo";
            $params = [
                ':id_user' => $usuarioId,
                ':fecha_cierre' => $fechaCierre,
                ':tipo' => 3
            ];
            $Utilidad=$this->row($sqlUtilidad, $params);
            $utilidadDelDia = (float)($Utilidad['utilidad'] ?: 0);

            // 3. Calcular Monto Final
            $montoFinal = $base + $utilidadDelDia;

            // 4. Insertar o Actualizar en cierres_diarios
            // Gracias al PK compuesta (usuario_id, fecha), usamos ON DUPLICATE KEY UPDATE
            $sqlInsert = "INSERT INTO cierres (id_usuario_fk, fecha, cierre_utilidades, cierre_saldo) 
                        VALUES (?, ?, ?, ?)
                        ON DUPLICATE KEY UPDATE 
                        cierre_utilidades = VALUES(cierre_utilidades), 
                        cierre_saldo = VALUES(cierre_saldo)";
            
            $parametros = [
                $usuarioId,
                $fechaCierre,
                $utilidadDelDia,
                $montoFinal
            ];

            return $this->query($sqlInsert, $parametros);

        } catch (Exception $e) {
            error_log("Error en cierre diario: " . $e->getMessage());
            return false;
        }
    }   

}