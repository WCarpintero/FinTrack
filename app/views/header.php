<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinTrack - Panel de Control</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= URL ?>/css/headerEstilos.css">
    
</head>
<body>
    <script>const Config = { BASE_URL: "<?= URL ?>" };</script>

    <aside class="sidebar d-none d-lg-block">
        <div class="p-4 mb-2">
            <a class="d-flex align-items-center text-decoration-none" href="<?= URL ?>/dashboard">
                <div class="brand-icon-container me-2">
                    <i class="bi bi-intersect text-white small"></i>
                </div>
                <span class="brand-text">FIN<span class="fw-light">TRACK</span></span>
            </a>
        </div>

        <nav class="mt-2">
            <a href="<?= URL ?>/dashboard" class="nav-link-custom <?= $active == 'dashboard' ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            <a href="<?= URL ?>/usuarios/main" class="nav-link-custom <?= $active == 'usuarios' ? 'active' : '' ?>">
                <i class="bi bi-people-fill"></i> Usuarios
            </a>
            <a href="<?= URL ?>/reportes" class="nav-link-custom <?= $active == 'reportes' ? 'active' : '' ?>">
                <i class="bi bi-graph-up-arrow"></i> Reportes
            </a>
        </nav>
    </aside>

    <div class="main-content">
        <nav class="navbar navbar-expand-lg sticky-top px-4 border-bottom">
            <div class="container-fluid">
                <div class="ms-auto d-flex align-items-center gap-3">

                    <div class="dropdown">
                        <button class="btn border-0 d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                            <span class="d-none d-md-block fw-semibold small"><?= $_SESSION['nombres'] ?? 'Usuario' ?></span>
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item py-2" href="<?= URL ?>/usuario/perfil"><i class="bi bi-person me-2"></i> Perfil</a></li>
                            <li><a class="dropdown-item py-2" href="<?= URL ?>/configuracion"><i class="bi bi-gear me-2"></i> Ajustes del Sistema</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2 text-danger" href="<?= URL ?>/auth/logout"><i class="bi bi-box-arrow-right me-2"></i> Salir</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <main class="p-4">
