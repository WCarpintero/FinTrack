<?php 
// 1. Definimos la página activa para la Sidebar
$active = 'dashboard'; 
require_once __DIR__.'/header.php'; 
?>

<style>
    /* Efecto de elevación para las cards de herramientas */
    .tool-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
    }
    .tool-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>

<div class="row g-4 mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-1 text-dark">Panel de Supervisión</h2>
            <p class="text-muted mb-0">Bienvenido de nuevo, <?= $_SESSION['nombres'] ?? 'Supervisor' ?>.</p>
        </div>
        <div class="d-none d-md-block">
            <span class="badge bg-white text-dark border shadow-sm px-3 py-2 rounded-pill">
                <i class="bi bi-calendar3 text-primary me-2"></i><?= date('d M, Y') ?>
            </span>
        </div>
    </div>

    <div class="col-12 mt-4">
        <div class="row g-4">
            <div class="col-md-4">
                <a href="<?= URL ?>/usuarios/main" class="text-decoration-none">
                    <div class="card tool-card p-4 h-100 border-0 shadow-sm border-bottom border-4 border-primary">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary-subtle p-3 rounded-3">
                                <i class="bi bi-people-fill text-primary fs-3"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold text-dark">Usuarios</h5>
                                <p class="mb-0 text-muted small">Administrar usuarios bajo supervisión.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="<?= URL ?>/movimiento/crear" class="text-decoration-none">
                    <div class="card tool-card p-4 h-100 border-0 shadow-sm border-bottom border-4 border-success">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-success-subtle p-3 rounded-3">
                                <i class="bi bi-plus-circle-fill text-success fs-3"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold text-dark">Nuevo Registro</h5>
                                <p class="mb-0 text-muted small">Registrar nuevas inversiones.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="<?= URL ?>/movimiento/listar" class="text-decoration-none">
                    <div class="card tool-card p-4 h-100 border-0 shadow-sm border-bottom border-4 border-info">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-info-subtle p-3 rounded-3">
                                <i class="bi bi-file-earmark-bar-graph-fill text-info fs-3"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold text-dark">Historial</h5>
                                <p class="mb-0 text-muted small">Reportes de movimientos.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col-12 mt-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-0">Análisis de Movimientos</h5>
                        <p class="text-muted small mb-0">Rendimiento global del portafolio</p>
                    </div>
                    <select class="form-select form-select-sm w-auto shadow-sm">
                        <option>Últimos 7 días</option>
                        <option>Este mes</option>
                        <option>Año actual</option>
                    </select>
                </div>
            </div>
            <div class="card-body p-4">
                <div style="position: relative; height:350px; width:100%">
                    <canvas id="mainChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Inicialización básica de Chart.js
    const ctx = document.getElementById('mainChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'],
            datasets: [{
                label: 'Inversiones (USDT)',
                data: [1200, 1900, 1500, 2500, 2200, 3000, 3500],
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.05)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                x: { grid: { display: false } }
            }
        }
    });
</script>

<?php require_once 'footer.php'; ?>