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

require_once "../app/models/Divisas.php";

$divisasModel = new Divisas();

switch ($action) {

    case 'listar':
        $divisas = $divisasModel->listarDivisas();
        echo json_encode([
            "success" => true,
            "data" => $divisas
        ]);
        break;

    default:
        require_once "../app/views/usuarios.php";
        break;
}
