<div class="row g-4 mb-5">
    <div class="col-12 d-flex justify-content-between align-items-end">
        <div>
            <h2 class="fw-bold mb-1">Panel de Supervisión</h2>
            <p class="text-muted mb-0">Bienvenido de nuevo a tu gestión financiera.</p>
        </div>
        <div class="text-end">
            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                <i class="bi bi-calendar3 me-2"></i><?= date('d M, Y') ?>
            </span>
        </div>
    </div>

    <div class="col-12 mt-4">
        <h5 class="fw-bold mb-3 text-secondary">Herramientas de Gestión</h5>
        <div class="row g-4">
            <div class="col-md-4">
                <a href="<?= URL ?>/usuarios/main" class="text-decoration-none">
                    <div class="card p-4 h-100 border-start border-4 border-primary shadow-sm">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary-subtle p-3 rounded-3">
                                <i class="bi bi-people-fill text-primary fs-3"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold text-dark">Usuarios</h5>
                                <p class="mb-0 text-muted small">Administrar accesos y roles.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="<?= URL ?>/movimiento/crear" class="text-decoration-none">
                    <div class="card p-4 h-100 border-start border-4 border-success shadow-sm">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-success-subtle p-3 rounded-3">
                                <i class="bi bi-plus-circle-fill text-success fs-3"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold text-dark">Nuevo Registro</h5>
                                <p class="mb-0 text-muted small">Ingresos y gastos.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="<?= URL ?>/movimiento/listar" class="text-decoration-none">
                    <div class="card p-4 h-100 border-start border-4 border-info shadow-sm">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-info-subtle p-3 rounded-3">
                                <i class="bi bi-file-earmark-bar-graph-fill text-info fs-3"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold text-dark">Historial</h5>
                                <p class="mb-0 text-muted small">Ver todos los movimientos.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col-12 mt-5">
        <div class="card shadow-sm border-0 overflow-hidden">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Análisis de Movimientos</h5>
                    <select class="form-select form-select-sm w-auto">
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