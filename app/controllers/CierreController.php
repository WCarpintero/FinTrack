<?php
require_once "../app/models/Usuario.php";
require_once "../app/models/Cierre.php"; 

$usuarioModel = new Usuario();
$cierreModel  = new Cierre();

$op = $_GET['op'] ?? '';

switch($op) {
    
    case 'ejecutarCierreMasivo':
        $usuarios = $usuarioModel->obtenerUsuariosActivos(); 

        if (empty($usuarios)) {
            echo json_encode(["success" => false, "mensaje" => "No hay usuarios para procesar"]);
            exit();
        }

        $exitos = 0;
        $errores = 0;

        foreach ($usuarios as $u) {
            $id = $u['id'] ; 
            
            $resultado = $cierreModel->generarCierreDiario($id);
            
            if ($resultado) {
                $exitos++;
            } else {
                $errores++;
            }
        }

        echo json_encode([
            "success" => true, 
            "mensaje" => "Proceso finalizado",
            "detalles" => "Éxitos: $exitos, Errores: $errores"
        ], JSON_UNESCAPED_UNICODE);
        exit();
        break;

    case 'otroCaso':
        // ...
        break;
}