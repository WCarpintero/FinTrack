<?php
session_start();

define('URL', 'http://localhost/fintrack');

// Obtener la ruta
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';

// --- LÓGICA DE PROTECCIÓN ---

// rutas "públicas" (no requieren login)
$rutas_publicas = ['login', 'auth/registro', 'auth/login'];

// Si el usuario NO tiene sesión y la ruta actual NO está en la lista de permitidas
if (!isset($_SESSION['id_usuario']) && !in_array($url, $rutas_publicas)) {
    header('Location: ' . URL . '/login');
    exit();
}

// Si el usuario TIENE sesión e intenta ir al login o registro, lo mandamos al dashboard
if (isset($_SESSION['id_usuario']) && ($url === 'login' || $url === 'auth/registro' || $url === '')) {
    header('Location: ' . URL . '/dashboard');
    exit();
}

// --- ENRUTADOR (Router) ---

switch ($url) {
    case 'auth/login':
        // Forzamos la acción 'acceder' para el switch del controlador
        $_GET['action'] = 'acceder';
        require_once '../app/controllers/LoginController.php';
        break;

    case 'auth/registro':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Si es POST, procesamos los datos con el controlador
            $_GET['action'] = 'autoRegistro'; 
            require_once '../app/controllers/UsuariosController.php';
            exit(); // Importante para que no cargue el HTML después del JSON
        } else {
            // Si es GET, mostramos la vista
            require_once '../app/views/registro.php';
        }
        break;

    //Procedimiento para registrar usuarios.
   case 'auth/registrar_completo':
        $_GET['action'] = 'registrarNuevo';
        require_once '../app/controllers/UsuariosController.php';
        exit();
        break;

     //Procedimiento para registrar usuarios.
   case 'usuarios/api/get_pares':
        $_GET['action'] = 'get_pares';
        require_once '../app/controllers/UsuariosController.php';
        exit();
        break;
    
    case 'usuarios/cambiar_estado':
        $_GET['action'] = 'cambiar_estado';
        require_once '../app/controllers/UsuariosController.php';
        break;

    case 'usuarios/actualizar':
        $_GET['action'] = 'actualizar_usuario';
        require_once '../app/controllers/UsuariosController.php';
        break;

    case 'dashboard':
        //Dashbpard principal 
        require_once '../app/views/dashboard.php';
        break;

    case 'reportes':
        //Dashbpard principal 
        require_once '../app/views/reportes.php';
        break;


    case 'login':
        // La vista de login
        require_once '../app/views/login.php'; 
        break;

    case 'usuarios/main':
        //Gestión de usuarios 
        require_once '../app/models/Usuario.php';
        require_once '../app/views/usuarios.php'; 
        break;

    case 'movimiento/crear':
        //Gestión de usuarios 
        require_once '../app/models/Movimientos.php';
        require_once '../app/views/movimientos.php'; 
        break;

    case 'movimiento/listar':
        //Gestión de usuarios 
        //require_once '../app/models/Usuario.php';
        require_once '../app/views/reportes.php'; 
        break;

    case 'usuarios/api/listar':
        // Listar usuarios en la tabla
        $_GET['action'] = 'getUsuarios';
        require_once '../app/controllers/UsuariosController.php';
        exit();
        break;

    case 'ejecutar/cierres':
        $_GET['op'] = 'ejecutarCierreMasivo';
        require_once '../app/controllers/CierreController.php';
        break; 
    case 'auth/logout':
        //Cerrar sesión 
        session_destroy();
        header('Location: ' . URL . '/login');
        break;

    default:
        echo "404 - La página no existe";
        break;
}