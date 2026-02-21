<?php 
require_once 'MainModel.php';

class Horarios extends MainModel{
    public function listarHorarios(){
        $sql = "SELECT id, hora FROM horario WHERE id!=3";
        return $this->table($sql); 
    }
}
