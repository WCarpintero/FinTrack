<?php 
require_once 'MainModel.php';

class Divisas extends MainModel{

    public function registrarDivisa($cod, $nombre, $simbolo){
        $sql = "INSERT INTO divisas(codigo, nombre, simbolo)
                VALUES(:codigo, :nombre, :simbolo)";

        $params = [
            ':codigo' => $cod, 
            ':nombre' =>$nombre,
            ':simbolo' => $simbolo
        ];

        return $this->query($sql, $params);
    }

    //Registrar par de divisas
    public function registrarPar($base, $cotizada){
        $sql = "INSERT INTO pares(base_fk, cotizada_fk)
                VALUES(:base, :cotizada)";

        $params = [
            ':base' => $base, 
            ':cotizada' => $cotizada
        ];

        return $this->query($sql, $params);
    }

    public function obtenerParesDisponibles(){
         $sql = "SELECT p.id,
                    d_base.codigo AS divisa_base,
                    d_cotizada.codigo AS divisa_cotizada,
                    CONCAT(d_base.codigo, '/', d_cotizada.codigo) AS nombre_completo
                FROM pares p
                INNER JOIN divisas d_base 
                    ON d_base.id = p.base_fk
                INNER JOIN divisas d_cotizada 
                    ON d_cotizada.id = p.cotizada_fk";

        return $this->table($sql);
    }

    public function obtenerIdDivisa($cod){
        $sql = "SELECT d.id
                FROM divisas d
                WHERE d.codigo = :cod";

        return $this->row($sql,[':cod' => $cod]);
    }

}