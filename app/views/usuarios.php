<?php 
$active = 'usuarios'; // Ilumina la opción en la Sidebar
require_once __DIR__ . '/header.php'; 
?>

<div id="usuariosApp" class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="<?= URL ?>/dashboard" class="text-decoration-none">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Gestión de Usuarios</li>
        </ol>
    </nav>

    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold mb-1">Gestión de Usuarios</h2>
            <p class="text-muted small mb-0">Monitorea y administra los usuarios bajo tu supervisión.</p>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#modalRegistro">
                <i class="bi bi-person-plus-fill me-2"></i>Nuevo Usuario
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <div class="row align-items-center g-3">
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-transparent border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" v-model="buscar" class="form-control border-start-0 ps-0" placeholder="Buscar por nombre, identificación o correo...">
                    </div>
                </div>
                <div class="col-auto ms-auto">
                    <button class="btn btn-light btn-sm border" title="Refrescar lista">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="small text-uppercase text-muted">
                        <th class="border-0 ps-4 py-3">ID</th>
                        <th class="border-0 py-3">Usuario / Contacto</th>
                        <th class="border-0 py-3 text-center">Saldo Actual</th>
                        <th class="border-0 py-3">Fechas Clave</th>
                        <th class="border-0 py-3">Estado</th>
                        <th class="border-0 text-end pe-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in usuariosFiltrados" 
                        :key="user.identificacion" 
                        class="border-top transition-all"
                        :class="{'bg-light opacity-75': user.estado != 1}">
                        <td class="ps-4">
                            <span class="badge bg-light text-dark border fw-bold">#{{ user.identificacion }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-3 bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.85rem;">
                                    {{ user.nombre[0] }}{{ user.apellido[0] }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark mb-0">{{ user.nombre }} {{ user.apellido }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">
                                        <i class="bi bi-envelope me-1"></i>{{ user.email }}
                                    </div>
                                    <div class="text-muted" style="font-size: 0.75rem;">
                                        <i class="bi bi-telephone me-1"></i>{{ user.telefono }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="fw-bold text-dark">
                                {{ Number(user.saldo_actual).toLocaleString('en-US', { minimumFractionDigits: 2 }) }}
                                <span class="text-muted small fw-normal">USDT</span>
                            </div>
                        </td>
                        <td>
                            <div class="small">
                                <div class="text-dark"><span class="text-muted">Registro:</span> {{ user.fecha_registro }}</div>
                                <div class="text-dark"><span class="text-muted">Operación:</span> {{ user.inicio_operaciones || '---' }}</div>
                            </div>
                        </td>
                        <td>
                            <span :class="['badge rounded-pill px-3', user.estado == 1 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger']">
                                {{ user.estado == 1 ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group border rounded shadow-sm bg-white">
                                <button @click="prepararEdicion(user)" class="btn btn-white btn-sm" title="Editar">
                                    <i class="bi bi-pencil text-primary"></i>
                                </button>
                                
                                <button @click="confirmarCambioEstado(user)" 
                                        class="btn btn-white btn-sm border-start" 
                                        :title="user.estado == 1 ? 'Inhabilitar' : 'Habilitar'">
                                    
                                    <i v-if="user.estado == 1" class="bi bi-person-x text-danger"></i>
                                    <i v-else class="bi bi-person-check text-success"></i>
                                    
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
    </div>
        <div class="card-footer bg-white border-0 py-3">
            <p class="text-muted small mb-0">Mostrando {{ usuariosFiltrados.length }} usuarios registrados.</p>
        </div>
    </div>
        <div class="modal fade" id="modalRegistro" tabindex="-1" aria-hidden="true" ref="modalRegistro">
            <div class="modal-dialog modal-lg modal-dialog-centered"> <div class="modal-content border-0 shadow">
                    <div class="modal-header border-0 pt-4 px-4">
                        <h5 class="fw-bold"><i class="bi bi-person-plus-fill me-2"></i>Registrar Nuevo Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form @submit.prevent="registrarUsuario">
                        <div class="modal-body p-4">
                            <h6 class="text-primary fw-bold mb-3 border-bottom pb-2">Datos Personales</h6>
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label class="small fw-bold mb-1">Identificación (Contraseña por defecto)</label>
                                    <input type="text" v-model="nuevo.identificacion" class="form-control" placeholder="Ej: 102030" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="small fw-bold mb-1">Nombre</label>
                                    <input type="text" v-model="nuevo.nombre" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="small fw-bold mb-1">Apellidos</label>
                                    <input type="text" v-model="nuevo.apellido" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small fw-bold mb-1">Correo Electrónico</label>
                                    <input type="email" v-model="nuevo.email" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="small fw-bold mb-1">Teléfono</label>
                                    <input type="text" v-model="nuevo.telefono" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="small fw-bold mb-1">Estado Inicial</label>
                                    <select v-model="nuevo.activo" class="form-select">
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>
                            </div>

                            <h6 class="text-primary fw-bold mb-3 border-bottom pb-2">Configuración de Inversión</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="small fw-bold mb-1">Total Pesos ($)</label>
                                    <input type="number" step="0.01" v-model="nuevo.total_invertido_pesos" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="small fw-bold mb-1">Invertido Cripto (USDT)</label>
                                    <input type="number" step="0.000001" v-model="nuevo.invertido_cripto" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="small fw-bold mb-1">Utilidades a la fecha (USDT)</label>
                                    <input type="number" step="0.000001" v-model="nuevo.saldo_actual" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="small fw-bold mb-1">Fecha Inicio Operaciones</label>
                                    <input type="date" v-model="nuevo.inicio_operaciones" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="small fw-bold mb-1">Par a Operar</label>
                                    <select v-model="nuevo.par_operar_fk" class="form-select" required>
                                        <option value="" disabled>Seleccione un par...</option>
                                        <option v-for="par in pares" :key="par.id" :value="par.id">
                                            {{ par.nombre_completo }} </option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="small fw-bold mb-1">Regalos/Bonos (USDT)</label>
                                    <input type="number" step="0.01" v-model="nuevo.regalos_bonos" class="form-control" value="0">
                                </div>
                            </div>

                            <div v-if="mensaje" :class="['alert mt-3 py-2 small', success ? 'alert-success' : 'alert-danger']">
                                {{ mensaje }}
                            </div>
                        </div>
                        <div class="modal-footer border-0 pb-4 px-4">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary px-4" :disabled="loading">
                                <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
                                Crear Cuenta y Configurar Inversión
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
     <?php require_once __DIR__ . '/modalEditarUsuario.php'; ?>
</div> 

<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="<?= URL ?>/javascript/gestionUsuarios.js"></script>

<?php require_once __DIR__ . '/footer.php'; ?>