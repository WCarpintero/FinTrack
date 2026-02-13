<?php

abstract class Controller{

    //Cargar vistas 
    public function render($view, $data = []){
        extract($data);
        $viewFile = __DIR__ . "/../views/" . $view . ".php";
        if(file_exists($viewFile)){
            require_once __DIR__ . "/../views/layouts/main.php";
        }else{
            die("LA VISTA {$view} NO EXISTE EN {$viewFile}");
        }
    }

    //Método para responder con JSON
    public function json($data){
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    //Método para auditorías (cuando se implementen)
    /*public function auditoria($movimiento_id, $accion, $anteriores = null, $nuevos = null){
        require_once __DIR__ . "/../models/Log.php";
        $logModel = new Log();
        $logData = [
            'movimiento_id_fk' => $movimiento_id,
            'ejecutor_id_fk'   => $_SESSION['usuario_id'] ?? 1, // Usuario en sesión
            'accion'           => $accion,
            'datos_anteriores' => $anteriores ? json_encode($anteriores) : null,
            'datos_nuevos'     => $nuevos ? json_encode($nuevos) : null
        ];
        return $logModel->registrar($logData);
    }*/

}
