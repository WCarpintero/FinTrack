<?php 
$active = 'reportes'; // Ilumina la opción en la Sidebar
require_once __DIR__ . '/header.php'; 
?>
<div id="historialApp" class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12 col-xl-8">
            <h3 class="fw-bold text-dark">Historial de Movimientos</h3>
            <p class="text-muted">Análisis detallado de flujos y cierres de utilidades.</p>
        </div>
        <div class="col-12 col-xl-4 text-xl-end">
            <button @click="exportarExcel" class="btn btn-success rounded-pill px-4 shadow-sm">
                <i class="bi bi-file-earmark-excel me-2"></i> Exportar Excel
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Periodo</label>
                    <select v-model="filtros.periodo" class="form-select border-0 bg-light rounded-3">
                        <option value="7">Últimos 7 días</option>
                        <option value="30">Último mes</option>
                        <option value="90">Últimos 3 meses</option>
                        <option value="180">Últimos 6 meses</option>
                        <option value="365">Último año</option>
                        <option value="all">Todos los registros</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Buscar Usuario</label>
                    <div class="input-group bg-light rounded-3">
                        <span class="input-group-text bg-transparent border-0"><i class="bi bi-person"></i></span>
                        <input type="text" v-model="filtros.usuario" class="form-control bg-transparent border-0" placeholder="Nombre o ID...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Fecha Específica</label>
                    <input type="date" v-model="filtros.fechaExacta" class="form-control border-0 bg-light rounded-3">
                </div>
                <div class="col-md-3">
                    <button @click="limpiarFiltros" class="btn btn-outline-secondary w-100 rounded-3">
                        Limpiar Filtros
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="small text-uppercase text-muted">
                                <th>Identificación</th>
                                <th>Usuario</th>
                                <th>Fecha</th>
                                <th class="text-end">Saldo Anterior</th>
                                <th class="text-end">Monto/Mov</th>
                                <th class="text-end text-primary">Cierre Utilidad</th>
                                <th class="text-end fw-bold">Saldo Final</th>
                                <th class="text-center">Ganancia</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in historialFiltrado" :key="item.id">
                                <td class="fw-bold">{{ item.identificacion }}</td>
                                <td>{{ item.nombre_usuario }}</td>
                                <td class="small">{{ item.fecha_registro }}</td>
                                <td class="text-end text-muted">$ {{ formatMoney(item.saldo_antes) }}</td>
                                <td class="text-end fw-bold" :class="item.monto >= 0 ? 'text-success' : 'text-danger'">
                                    {{ item.monto >= 0 ? '+' : '' }} {{ formatMoney(item.monto) }}
                                </td>
                                <td class="text-end text-primary fw-bold">$ {{ formatMoney(item.cierre_utilidades) }}</td>
                                <td class="text-end fw-bold">$ {{ formatMoney(item.cierre_saldo) }}</td>
                                <td class="text-center">
                                    <span class="badge" :class="item.ganancia > 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'">
                                        {{ item.ganancia > 0 ? '+' : '' }} {{ formatMoney(item.ganancia) }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card border-0 shadow-sm bg-primary text-white p-3 mb-3">
                <h6 class="mb-0">Resumen de Cierres</h6>
                <p class="small opacity-75 mb-0">Última actualización: {{ hoy }}</p>
            </div>
            <div class="timeline-container p-2">
                <h6 class="fw-bold small text-muted text-uppercase mb-3">Línea de Tiempo</h6>
                <div class="timeline-item border-start border-primary ps-3 pb-3 position-relative" v-for="cierre in cierresRecientes" :key="cierre.fecha_pk">
                    <div class="dot bg-primary position-absolute rounded-circle" style="width: 10px; height: 10px; left: -5.5px; top: 5px;"></div>
                    <span class="text-muted d-block" style="font-size: 0.7rem;">{{ cierre.fecha_pk }}</span>
                    <span class="fw-bold d-block small">Utilidad: ${{ formatMoney(cierre.cierre_utilidades) }}</span>
                    <span class="text-muted small">Saldo: ${{ formatMoney(cierre.cierre_saldo) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<?php require_once __DIR__ . '/footer.php'; ?>