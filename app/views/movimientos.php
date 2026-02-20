<?php 
$active = 'movimientos_registro'; 
require_once __DIR__ . '/header.php'; 
?>

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

                        <div class="mb-3">
                            <label class="small fw-bold mb-1">Monto Operado (USDT)</label>
                            <input type="number" step="0.01" v-model="movimiento.monto" class="form-control" placeholder="0.00" required>
                        </div>

                        <div class="mb-4">
                            <label class="small fw-bold mb-1">Utilidad Neta (USDT)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted">+/-</span>
                                <input type="number" step="0.000001" v-model="movimiento.utilidad" 
                                       class="form-control fw-bold" 
                                       :class="{'text-success': movimiento.utilidad > 0, 'text-danger': movimiento.utilidad < 0}"
                                       placeholder="Ej: 15.50 o -10.20" required>
                            </div>
                            <div class="form-text small">Use el signo menos (-) para registrar pérdidas.</div>
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
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">Historial Reciente</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="small text-uppercase text-muted">
                                <th class="ps-4">Usuario</th>
                                <th>Monto Operado</th>
                                <th class="text-center">Utilidad</th>
                                <th class="pe-4">Fecha/Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="mov in movimientos" :key="mov.id" class="border-top">
                                <td class="ps-4">
                                    <div class="fw-bold">{{ mov.usuario_nombre }}</div>
                                    <div class="text-muted small">{{ mov.tipo_nombre }} ({{ mov.horario_texto }})</div>
                                </td>
                                <td>{{ Number(mov.monto).toLocaleString() }} USDT</td>
                                <td class="text-center">
                                    <span :class="['fw-bold', mov.utilidad >= 0 ? 'text-success' : 'text-danger']">
                                        {{ mov.utilidad >= 0 ? '+' : '' }}{{ mov.utilidad }}
                                    </span>
                                </td>
                                <td class="pe-4 small text-muted">{{ mov.fecha_registro }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="<?= URL ?>/javascript/gestionMovimientos.js"></script>
<?php require_once __DIR__ . '/footer.php'; ?>