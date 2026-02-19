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

$usuarioModel = new Usuario();
$inversionModel = new UsuarioInversion();
$divisas = new Divisas();
$movimiento = new Movimientos();

switch ($action) {

    case 'getUsuarios':

        header('Content-Type: application/json');  
        $usuarios = $usuarioModel->listarUsuarios();
        
        // Unimos el saldo a cada usuario
        foreach ($usuarios as &$u) {
            //Añadir saldo actual del usuario a la lista
            $saldoData = $inversionModel->obtenerSaldo($u['id']);
            $u['saldo_actual'] = $saldoData['saldo_actual_cripto'] ?? 0;

            //Añadir fecha de inicio de operaciones
            $fechaRes = $inversionModel->obtenerInicioOperaciones($u['id']);
            $u['inicio_operaciones'] =($fechaRes && isset($fechaRes['inicio_operaciones'])) 
                                        ? $fechaRes['inicio_operaciones'] 
                                        : null;
            // Ajustamos el estado para que sea legible
            $u['estado_label'] = ($u['estado'] == 1) ? 'Activo' : 'Inactivo';
        }

        unset($u);
        
        echo json_encode(["success" => true, "data" => $usuarios]);
        exit();
        break;

    case 'registrarNuevo':
        header('Content-Type: application/json');

        // 1. Recoger y limpiar datos
        $identificacion = trim($_POST['identificacion'] ?? '');
        $nombre         = trim($_POST['nombre'] ?? '');
        $apellido       = trim($_POST['apellido'] ?? '');
        $email          = trim($_POST['email'] ?? '');
        $telefono       = trim($_POST['telefono'] ?? '');
        $fecha_inicio   = $_POST['inicio_operaciones'] ?? date('Y-m-d');

        // 2. Datos de inversión
        $datosInv = [
            'usuario_id'   => null,
            'monto_pesos'  => $_POST['total_invertido_pesos'] ?? 0,
            'monto_cripto' => $_POST['invertido_cripto'] ?? 0,
            'fecha_inicio' => $fecha_inicio,
            'id_par'       => $_POST['par_operar_fk'] ?? null,
            'regalos'      => $_POST['regalos_bonos'] ?? 0,
            'saldo_actual' => $_POST['saldo_actual'] ?? 0
        ];

        // 3. Validaciones previas
        if (empty($identificacion) || empty($nombre) || empty($email)) {
            echo json_encode(["success" => false, "mensaje" => "Datos básicos incompletos"]);
            exit();
        }

        if ($usuarioModel->verificarCorreo($email)) {
            echo json_encode(["success" => false, "mensaje" => "El correo ya existe"]);
            exit();
        }
        
        $passHash = password_hash($identificacion, PASSWORD_DEFAULT);

        try {
            $usuarioModel->beginTransaction();

            // 4. Crear Usuario
            $usuarioCreado = $usuarioModel->crearUsuario($identificacion, $nombre, $apellido, $email, $telefono, $passHash, 2);
            if (!$usuarioCreado) throw new Exception("No se pudo crear el perfil de usuario.");

            // 5. Obtener ID
            $userRes = $usuarioModel->getIdUsuario($email);
            $idUsuario = $userRes['id'];
            $datosInv['usuario_id'] = $idUsuario;

            // 6. Registrar Inversión
            $inversionOk = $inversionModel->registrarInversion($datosInv);
            if (!$inversionOk) throw new Exception("Error al registrar la configuración de inversión.");

            // 7. Registrar movimiento inicial (Tipo 3)
            $idDivisaRes = $divisas->obtenerIdDivisa('USDT');
            $idDivisa = $idDivisaRes['id'];
            
            $monto = (float)$datosInv['saldo_actual'];
            
            $movimientoReg = $movimiento->movimientoRegistroUsuario($idUsuario, 3, $idDivisa, $monto, 3, 0, $fecha_inicio);
            if (!$movimientoReg) throw new Exception("Error al registrar el movimiento de apertura.");

            $usuarioModel->commit();
            
            echo json_encode(["success" => true, "mensaje" => "Usuario, inversión y movimiento registrados con éxito"]);

        } catch (Exception $e) {
            // Si algo falló, deshacemos todo lo que se alcanzó a insertar
            $usuarioModel->rollBack();
            echo json_encode(["success" => false, "mensaje" => "Error: " . $e->getMessage()]);
        }
        
        exit();
        break;
    
    case 'autoRegistro':
        //Este es el registro que se hace desde el login, solo para supervisores
         
        header('Content-Type: application/json');

        // 1. Recoger y limpiar datos
        $identificacion = trim($_POST['identificacion'] ?? '');
        $nombre         = trim($_POST['nombre'] ?? '');
        $apellido       = trim($_POST['apellido'] ?? '');
        $email          = trim($_POST['email'] ?? '');
        $telefono       = trim($_POST['telefono'] ?? '');
        $password = trim($_POST['password'] ??'');
        $rol = 1; // Rol de supervisor

        // 2. Validaciones
        if (empty($identificacion) || empty($nombre) || empty($email)|| empty($password)) {
            echo json_encode(["success" => false, "mensaje" => "Datos básicos incompletos"]);
            exit();
        }

        if ($usuarioModel->verificarCorreo($email)) {
            echo json_encode(["success" => false, "mensaje" => "El correo ya existe"]);
            exit();
        }

        // 3. Crear Usuario (Password = Identificación)
        $passHash = password_hash($password, PASSWORD_DEFAULT);

        $supervisor = $usuarioModel->crearUsuario(
            $identificacion, 
            $nombre, 
            $apellido, 
            $email, 
            $telefono, 
            $passHash, 
            $rol
        );

        if ($supervisor) {
            echo json_encode(["success" => true, "mensaje" => "Usuario registrado con éxito"]);
        } else {
            echo json_encode(["success" => false, "mensaje" => "Error al registrar usuario"]);
        }

        exit();
        break; 

    case 'get_pares':
        header('Content-Type: application/json');
        // Supongamos que tienes un modelo para los pares o usas una consulta directa
        $pares = $divisas->obtenerParesDisponibles(); 
        echo json_encode(["success" => true, "data" => $pares]);
        exit();
        break;

    // --- CASE ACTUALIZAR PERFIL ---
    case 'actualizar_usuario':
        header('Content-Type: application/json');
        
        $id       = $_POST['id'] ?? null;
        $nombre   = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $estado   = $_POST['estado'] ?? 1;

        if (!$id || empty($nombre) || empty($email)) {
            echo json_encode(["success" => false, "mensaje" => "Faltan datos obligatorios"]);
            exit();
        }

        $actualizado = $usuarioModel->actualizarUsuario($id, $nombre, $apellido, $email, $telefono, $estado);

        if ($actualizado) {
            echo json_encode(["success" => true, "mensaje" => "Usuario actualizado"]);
        } else {
            echo json_encode(["success" => false, "mensaje" => "No se realizaron cambios o error en DB"]);
        }
        break;

    case 'cambiar_estado':
        header('Content-Type: application/json');
        $id = $_POST['id'] ?? null;
        $estado = $_POST['estado'] ?? null; // 0 o 1 del JS

        if ($id === null || $estado === null) {
            echo json_encode(["success" => false, "mensaje" => "Datos incompletos"]);
            exit();
        }

        $resultado = $usuarioModel->cambiarEstado($id, $estado);

        if ($resultado) {
            echo json_encode(["success" => true, "mensaje" => "Estado actualizado"]);
        } else {
            echo json_encode(["success" => false, "mensaje" => "Error en base de datos"]);
        }
        break;

    case 'index':
        default:
        require_once "../app/views/usuarios.php";
        break;
}