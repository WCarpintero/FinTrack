<?php 
$active = 'movimientos_registro'; 
require_once __DIR__ . '/header.php'; 
?>
<link rel="stylesheet" href="<?= URL ?>/css/movimientos.css">

<div id="movimientosApp" class="container-fluid">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold mb-1">Registro de Movimientos</h2>
            <p class="text-muted small mb-0">Gestión de operaciones diarias y utilidades.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-graph-up-arrow me-2 text-primary"></i>Nueva Operación</h6>
                </div>
                <div class="card-body">
                    <form @submit.prevent="registrarMovimiento">
                        <div class="mb-3">
                            <label class="small fw-bold mb-1">Usuario</label>
                            <select v-model="movimiento.usuario_fk" class="form-select" required>
                                <option value="" disabled>Seleccione un usuario...</option>
                                <option v-for="user in usuarios" :key="user.id" :value="user.id">
                                    {{ user.nombre }} {{ user.apellido }}
                                </option>
                            </select>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="small fw-bold mb-1">Tipo de Operación</label>
                                <select v-model="movimiento.tipo_movimiento_fk" class="form-select" required>
                                    <option v-for="tipo in tipos" :key="tipo.id" :value="tipo.id">{{ tipo.nombre }}</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold mb-1">Horario</label>
                                <select v-model="movimiento.horario_fk" class="form-select" required>
                                    <option v-for="h in horarios" :key="h.id" :value="h.id">{{ h.hora }}</option>
                                </select>
                            </div>
                        </div>

                        <!--<div class="mb-3">
                            <label class="small fw-bold mb-1">Monto Operado (USDT)</label>
                            <input type="number" step="0.01" v-model="movimiento.monto" class="form-control" placeholder="0.00" required>
                        </div>-->
                        <div class="row g-2 mb-3">
                            <div class="col-md-8">
                                <label class="small fw-bold mb-1">Monto Operado</label>
                                <input type="number" step="0.01" v-model="movimiento.monto" class="form-control" placeholder="0.00" required>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold mb-1">Divisa</label>
                                <select v-model="movimiento.divisa_fk" class="form-select" required>
                                    <option v-for="divisa in divisas" :key="divisa.id" :value="divisa.id">{{ divisa.codigo }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="small fw-bold mb-1">Utilidad Generada</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted">+/-</span>
                                <input type="number" step="0.01" v-model="movimiento.utilidad" 
                                       class="form-control fw-bold" 
                                       :class="{'text-success': movimiento.utilidad > 0, 'text-danger': movimiento.utilidad < 0}"
                                       placeholder="Ej: 7.50" required>
                            </div>
                            <div class="form-text small">Use el signo menos (-) para registrar pérdidas.</div>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold mb-1">Fecha de Operación</label>
                            <input type="date" v-model="movimiento.fecha_operacion" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label class="small fw-bold mb-1">Nota (Opcional)</label>
                            <textarea v-model="movimiento.descripcion" class="form-control" rows="2"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 shadow-sm" :disabled="loading">
                            <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
                            Guardar Movimiento
                        </button>

                        <div v-if="mensaje" :class="['alert mt-3 py-2 small', success ? 'alert-success' : 'alert-danger']">
                            {{ mensaje }}
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Historial Reciente (últimos 3 días)</h6>
                    <span class="badge bg-primary-subtle text-primary rounded-pill small">{{ historial.length }} Movimientos</span>
                </div>
                
                <div class="table-responsive" style="max-height: 550px; overflow: auto; border-bottom: 1px solid #dee2e6;">
                    <table class="table table-hover align-middle mb-0" style="min-width: 900px;">
                        <thead class="bg-light sticky-top" style="z-index: 10; top: 0;">
                            <tr class="small text-uppercase text-muted border-bottom">
                                <th class="ps-4 bg-light" style="width: 180px;">Usuario</th>
                                <th class="bg-light" style="width: 140px;">Acción</th>
                                <th class="text-center bg-light" style="width: 160px;">Monto operado</th>
                                <th class="text-center bg-light" style="width: 160px;">Utilidad</th>
                                <th class="pe-4 bg-light" style="width: 180px;">Fecha Operación</th>
                                <th class="pe-4 bg-light d-none d-md-table-cell" style="width: 180px;">Fecha Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="historial.length === 0">
                                <td colspan="6" class="text-center py-5 text-muted">No se encontraron movimientos.</td>
                            </tr>
                            <tr v-for="mov in historial" :key="mov.id" class="border-top">
                                <td class="ps-4">
                                    <div style="font-family: 'Inter', system-ui, sans-serif; font-weight: 700; font-size: 14px; color: #000000; letter-spacing: -0.01em;">
                                        {{ mov.usuario }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border-0">{{ mov.tipo_movimiento }}</span>
                                </td>
                                <td class="text-center fw-bold">
                                    {{ Number(mov.monto).toLocaleString() }} 
                                    <small class="text-muted">{{ mov.divisa }}</small>
                                </td>
                                <td class="text-center">
                                    <span :class="['fw-bold', mov.utilidad >= 0 ? 'text-success' : 'text-danger']">
                                        {{ mov.utilidad >= 0 ? '+' : '' }}{{ mov.utilidad }} 
                                        <small>{{ mov.divisa }}</small>
                                    </span>
                                </td>
                                <td class="pe-4 small text-muted text-nowrap">{{ mov.operado }}</td>
                                <td class="pe-4 small text-muted text-nowrap d-none d-md-table-cell">{{ mov.registro }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white py-2 text-center">
                    <small class="text-muted">Deslice horizontalmente para ver más columnas en móviles</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="<?= URL ?>/javascript/gestionMovimientos.js"></script>
<?php require_once __DIR__ . '/footer.php'; ?>