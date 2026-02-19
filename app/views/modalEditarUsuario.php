<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-white border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold d-flex align-items-center" id="modalEditarLabel">
                    <div class="icon-box bg-primary-subtle text-primary rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    Editar Perfil de Usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form @submit.prevent="actualizarUsuario">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted mb-1">Número de Identificación</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-card-text"></i></span>
                                <input type="text" v-model="usuarioEdit.identificacion" class="form-control bg-light border-start-0" readonly>
                            </div>
                            <div class="form-text" style="font-size: 0.7rem;">La identificación no puede ser modificada por seguridad.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted mb-1">Nombre</label>
                            <input type="text" v-model="usuarioEdit.nombre" class="form-control" placeholder="Ej. Juan" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted mb-1">Apellido</label>
                            <input type="text" v-model="usuarioEdit.apellido" class="form-control" placeholder="Ej. Pérez" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted mb-1">Correo Electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                                <input type="email" v-model="usuarioEdit.email" class="form-control" placeholder="nombre@ejemplo.com" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted mb-1">Teléfono / WhatsApp</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-whatsapp"></i></span>
                                <input type="text" v-model="usuarioEdit.telefono" class="form-control" placeholder="300..." required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted mb-1">Estado de Cuenta</label>
                            <select v-model="usuarioEdit.estado" class="form-select" required>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo / Inhabilitado</option>
                            </select>
                        </div>
                    </div>

                    <div v-if="mensajeEdit" :class="['alert mt-4 py-2 small border-0 shadow-sm', successEdit ? 'alert-success' : 'alert-danger']">
                        <i :class="['bi me-2', successEdit ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill']"></i>
                        {{ mensajeEdit }}
                    </div>
                </div>

                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" :disabled="loadingEdit">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm" :disabled="loadingEdit">
                        <span v-if="loadingEdit" class="spinner-border spinner-border-sm me-2" role="status"></span>
                        <i v-else class="bi bi-save me-2"></i>
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>