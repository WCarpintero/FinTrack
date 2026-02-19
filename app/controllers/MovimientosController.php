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


case 'index':
        default:
        require_once "../app/views/usuarios.php";
        break;
}