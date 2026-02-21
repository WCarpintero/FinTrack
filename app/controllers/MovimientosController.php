<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$action = $_GET['action'] ?? 'index';

// Protección: Si no hay sesión, no entra a este controlador
if (!isset($_SESSION['id_usuario']) && $action !== 'autoRegistro') {
    header('Location: ' . URL . '/login');
    exit();
}

require_once "../app/models/Usuario.php";
require_once "../app/models/UsuarioInversion.php";
require_once "../app/models/Divisas.php";
require_once "../app/models/Movimientos.php";
require_once "../app/models/Horarios.php";

$usuarioModel = new Usuario();
$inversionModel = new UsuarioInversion();
$divisasModel = new Divisas();
$movimientoModel = new Movimientos();
$horariosModel = new Horarios();

switch ($action) {

    case 'listar/tipos/movimiento':
        $tipos = $movimientoModel->listarTiposMovimiento();
        echo json_encode([
            "success" => true,
            "data" => $tipos
        ]);
        break;
    case 'listar/horarios':
        $horarios = $horariosModel->listarHorarios();
        echo json_encode([
            "success" => true,
            "data" => $horarios
        ]);
        break;

    case 'registrarMovimiento':
        header('Content-Type: application/json');

        // 1. Capturar el JSON desde el cuerpo de la petición (sustituye a $_POST)
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!$data) {
            echo json_encode(["success" => false, "message" => "No se recibieron datos válidos."]);
            break;
        }

        // 2. Recoger y limpiar datos del array $data
        $usuario         = trim($data['usuario_fk'] ?? '');
        $tipoMovimiento  = trim($data['tipo_movimiento_fk'] ?? '');
        $divisa          = trim($data['divisa_fk'] ?? '');
        $monto           = trim($data['monto'] ?? '0');
        $horario         = trim($data['horario_fk'] ?? '');
        $resultado       = trim($data['utilidad'] ?? '0');
        $descripcion     = trim($data['descripcion'] ?? '');
        $fecha_operacion = !empty($data['fecha_operacion']) ? $data['fecha_operacion'] : date('Y-m-d');

        // 3. Validación mínima antes de llamar al modelo
        if (empty($usuario) || empty($monto)) {
            echo json_encode(["success" => false, "message" => "Faltan campos obligatorios (Usuario o Monto)."]);
            break;
        }

        // 4. Ejecutar el registro en el modelo
        $registro = $movimientoModel->registrarMovimiento(
            $usuario, 
            $tipoMovimiento, 
            $divisa, 
            $monto, 
            $horario, 
            $resultado, 
            $descripcion, 
            $fecha_operacion
        );

        // 5. Respuesta final
        if ($registro) {
            echo json_encode([
                "success" => true, 
                "message" => "Movimiento registrado correctamente.", 
                "data" => $registro
            ]);
        } else {
            echo json_encode([
                "success" => false, 
                "message" => "Error al registrar el movimiento en la base de datos."
            ]);
        }
        break;

    case 'listarHistorial':
        header('Content-Type: application/json');

        $historial = $movimientoModel->breveHistorial();
        echo json_encode([
            "success" => true,
            "data" => $historial
        ]);
        break;

    default:
        require_once "../app/views/usuarios.php";
        break;
}
