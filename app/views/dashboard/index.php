<div class="container-fluid pt-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Gestión de Supervisión</h2>
            <p class="text-secondary">Panel central para el control de registros y análisis de usuarios bajo su cargo.</p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-3">
                        <i class="bi bi-plus-circle-fill text-primary fs-3"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="card-title fw-bold mb-0">Nuevo Registro</h5>
                        <p class="card-text text-muted mb-2">Ingresar movimientos para los usuarios supervisados.</p>
                        <a href="<?= URL ?>/movimiento/nuevo" class="btn btn-primary btn-sm rounded-pill px-3">
                            Ir a Registrar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded-3">
                        <i class="bi bi-file-earmark-bar-graph-fill text-success fs-3"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="card-title fw-bold mb-0">Consultar Reportes</h5>
                        <p class="card-text text-muted mb-2">Visualizar estadísticas y exportar historial de datos.</p>
                        <a href="<?= URL ?>/movimiento/listar" class="btn btn-success btn-sm rounded-pill px-3">
                            Ver Reportes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold">Distribución de Registros</h5>
                    <div class="badge bg-light text-dark border">Gráficos Dinámicos</div>
                </div>
                
                <div style="position: relative; height:40vh; width:100%">
                    <canvas id="graficoSupervision"></canvas>
                </div>
                
                <div class="text-center mt-3" v-if="cargando">
                    <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                    <small class="text-muted ms-2">Cargando datos dinámicos...</small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $extraScripts = "
<script>
    app.config.globalProperties.cargando = true;
    
    // Aquí integraremos Chart.js con los datos de Movimiento.php más adelante
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('graficoSupervision').getContext('2d');
        // Instancia de gráfico vacía o con datos de prueba
    });
</script>
"; ?>