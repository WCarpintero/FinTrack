<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__."/../models/Login.php";
$authModel = new Login();

$action = $_GET['action'] ?? 'index';
$response = []; 

switch ($action) {
    case 'acceder':
        header('Content-Type: application/json'); // Avisamos que responderemos JSON
        
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            echo json_encode(["success" => false, "mensaje" => "Email o contraseña vacíos"]);
            exit();
        }

        $usuario = $authModel->autenticar($email, $password);

        if ($usuario) {
            $_SESSION['id_usuario'] = $usuario['id'];
            $_SESSION['nombres']    = $usuario['nombre'] . ' ' . $usuario['apellido'];
            $_SESSION['rol']        = $usuario['rol_fk'];
        
            echo json_encode(["success" => true, "mensaje" => "Sesión iniciada", "redirect" => URL . "/dashboard"]);
        } else {
            echo json_encode(["success" => false, "mensaje" => "Usuario o contraseña inválidos"]);
        }
        exit(); // IMPORTANTE detener aquí
        break;

    case 'salir':
        session_destroy();
        header('Location: ' . URL . '/login'); // El logout 
        exit();
        break;

    case 'index':
    default:
        if (isset($_SESSION['id_usuario'])) {
            header('Location: ' . URL . '/dashboard');
            exit();
        }
        require_once "../views/login.php";
        break;
}