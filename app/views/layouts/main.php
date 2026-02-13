<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinTrack - Gestión Financiera</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #212529; color: white; }
        .nav-link { color: rgba(255,255,255,.8); border-radius: 8px; margin: 4px 10px; }
        .nav-link:hover, .nav-link.active { background: #343a40; color: white; }
        .main-content { min-height: 100vh; }
    </style>
</head>
<body>

<div id="app" class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse p-0 shadow">
            <div class="p-4 mb-2 text-center">
                <h4 class="fw-bold text-primary">Fin<span class="text-white">Track</span></h4>
                <small class="text-muted">Sistema de Gestión</small>
            </div>
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="<?= URL ?>/dashboard">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>/movimiento/listar">
                        <i class="bi bi-cash-stack me-2"></i> Movimientos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL ?>/usuario/perfil">
                        <i class="bi bi-person me-2"></i> Mi Perfil
                    </a>
                </li>
                <hr class="mx-3 text-secondary">
                <li class="nav-item">
                    <a class="nav-link text-danger" href="<?= URL ?>/auth/logout">
                        <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                    </a>
                </li>
            </ul>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
            <header class="navbar navbar-light sticky-top bg-white border-bottom p-3 mb-4 mx-n4">
                <span class="navbar-text fw-semibold ms-3">
                    Hola, <?= $_SESSION['nombres'] ?? 'Usuario' ?>
                </span>
                <div class="dropdown me-3">
                    <button class="btn btn-light dropdown-toggle shadow-sm" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Ajustes</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Salir</a></li>
                    </ul>
                </div>
            </header>

            <div class="container-fluid">
                <?php 
                    if (isset($viewFile) && file_exists($viewFile)) {
                        include $viewFile; 
                    } else {
                        echo "<div class='alert alert-danger'>Contenido no encontrado.</div>";
                    }
                ?>
            </div>
        </main>
    </div>
</div>

<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const { createApp } = Vue;
    // Iniciamos Vue aquí para que esté disponible en todas las vistas hijas
    const app = createApp({
        data() {
            return {
                // Datos globales si fueran necesarios
            }
        }
    });
</script>

<?php if (isset($extraScripts)) echo $extraScripts; ?>

<script>
    app.mount('#app');
</script>

</body>
</html>