<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinTrack | Business Intelligence</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --sidebar-bg: #0f172a; /* Slate 900 */
            --main-bg: #f1f5f9;    /* Slate 100 */
            --accent-color: #3b82f6; /* Blue 500 */
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--main-bg); 
            color: #1e293b;
        }

        /* Sidebar Estilizada */
        .sidebar { 
            min-height: 100vh; 
            background: var(--sidebar-bg); 
            padding: 1.5rem 1rem;
            transition: all 0.3s;
        }

        .brand-logo {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -1px;
            padding: 0 1rem 2rem;
            color: white;
        }

        .nav-link { 
            color: #94a3b8; 
            font-weight: 500;
            padding: 0.8rem 1rem;
            border-radius: 12px;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            transition: 0.2s;
        }

        .nav-link i { font-size: 1.2rem; }

        .nav-link:hover { 
            background: #1e293b; 
            color: white; 
        }

        .nav-link.active { 
            background: var(--accent-color); 
            color: white; 
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        /* Header / Navbar */
        .top-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 2rem;
        }

        /* Contenedor de Contenido */
        .content-wrapper {
            padding: 2rem;
        }

        /* Card Modernas */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .btn-modern {
            border-radius: 10px;
            padding: 0.6rem 1.2rem;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div id="app" class="container-fluid p-0">
    <div class="d-flex">
        <aside class="sidebar col-md-3 col-lg-2 d-none d-md-block shadow-lg">
            <div class="brand-logo">
                <i class="bi bi-intersect text-primary me-2"></i>Fin<span class="text-primary">Track</span>
            </div>
            
            <nav class="nav flex-column mt-2">
                <a class="nav-link active" href="<?= URL ?>/dashboard">
                    <i class="bi bi-grid-1x2-fill me-3"></i> Dashboard
                </a>
                <a class="nav-link" href="<?= URL ?>/movimiento/listar">
                    <i class="bi bi-arrow-left-right me-3"></i> Registros
                </a>
                <a class="nav-link" href="<?= URL ?>/usuario/perfil">
                    <i class="bi bi-person-gear me-3"></i> Perfil
                </a>
                
                <div class="mt-auto pt-5">
                    <hr class="text-secondary opacity-25">
                    <a class="nav-link text-danger-emphasis" href="<?= URL ?>/auth/logout">
                        <i class="bi bi-power me-3"></i> Salir
                    </a>
                </div>
            </nav>
        </aside>

        <main class="flex-grow-1 overflow-auto vh-100">
            <header class="top-nav d-flex justify-content-between align-items-center sticky-top">
                <div class="search-bar d-none d-lg-block">
                    <h5 class="m-0 fw-bold text-dark">Panel de Supervisión</h5>
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    <div class="text-end d-none d-sm-block">
                        <p class="m-0 small fw-bold text-dark"><?= $_SESSION['nombres'] ?? 'Supervisor' ?></p>
                        <p class="m-0 small text-muted" style="font-size: 0.7rem;">Admin Acceso</p>
                    </div>
                    <div class="dropdown">
                        <button class="btn border-0 p-0" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name=<?= $_SESSION['nombres'] ?? 'U' ?>&background=3b82f6&color=fff" 
                                 class="rounded-circle shadow-sm" width="40" height="40">
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3 p-2" style="border-radius: 12px;">
                            <li><a class="dropdown-item rounded-2" href="#"><i class="bi bi-gear me-2"></i>Ajustes</a></li>
                            <li><hr class="dropdown-divider opacity-50"></li>
                            <li><a class="dropdown-item rounded-2 text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</a></li>
                        </ul>
                    </div>
                </div>
            </header>

            <div class="content-wrapper">
                <?php 
                    /* Área donde se inyecta el contenido dinámico (Dashboard, Formularios, etc.)
                    */
                    if (isset($viewFile) && file_exists($viewFile)) {
                        include $viewFile; 
                    } else {
                        echo "
                        <div class='text-center py-5'>
                            <i class='bi bi-exclamation-circle text-muted display-1'></i>
                            <h4 class='mt-3 text-secondary'>Contenido no disponible</h4>
                            <p class='text-muted'>La vista solicitada no fue encontrada.</p>
                        </div>";
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
    const app = createApp({
        data() {
            return { cargando: false }
        }
    });
</script>

<?php if (isset($extraScripts)) echo $extraScripts; ?>

<script>
    app.mount('#app');
</script>

</body>
</html>