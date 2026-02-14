<div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold mb-0">Registrar Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="<?= URL ?>/usuario/guardar" method="POST">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Identificación</label>
                            <input type="text" name="identificacion" class="form-control bg-light border-0 py-2" placeholder="Ej: 1090..." required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nombres</label>
                            <input type="text" name="nombres" class="form-control bg-light border-0 py-2" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Apellidos</label>
                            <input type="text" name="apellidos" class="form-control bg-light border-0 py-2" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control bg-light border-0 py-2" placeholder="nombre@ejemplo.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Rol de Acceso</label>
                            <select name="rol_id" class="form-select bg-light border-0 py-2">
                                <option value="1">Administrador</option>
                                <option value="2">Usuario Estándar</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Contraseña</label>
                            <input type="password" name="password" class="form-control bg-light border-0 py-2" required>
                        </div>
                    </div>
                    
                    <div class="mt-4 d-grid">
                        <button type="submit" class="btn btn-primary py-2 fw-bold">Guardar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>