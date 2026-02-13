
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinTrack - Panel de Control</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
       /* Estilos para el nuevo Logo */
    .brand-icon-container {
        background: linear-gradient(135deg, #0d6efd 0%, #003da1 100%);
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
    }
    
    .brand-text {
        font-weight: 800;
        letter-spacing: -0.5px;
        font-size: 1.4rem;
        background: linear-gradient(135deg, #1e293b 0%, #475569 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    /* Efecto Glassmorphism sutil para el nav */
    .navbar {
        background: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top mb-4">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?= URL ?>/dashboard">
            <div class="brand-icon-container me-2">
                <i class="bi bi-intersect text-white"></i>
            </div>
            <span class="brand-text">
                FIN<span class="fw-light">TRACK</span>
            </span>
        </a>

        <div class="ms-auto d-flex align-items-center">
            <div class="dropdown">
                <button class="btn border-0 d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                    <span class="d-none d-md-block fw-semibold"><?= $_SESSION['nombres'] ?? 'Usuario' ?></span>
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                    <li><a class="dropdown-item py-2" href="<?= URL ?>/usuario/perfil"><i class="bi bi-person me-2"></i> Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item py-2 text-danger" href="<?= URL ?>/auth/logout"><i class="bi bi-box-arrow-right me-2"></i> Salir</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<main class="container">