<div class="row g-4 mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-1">Gestión de Usuarios</h2>
            <p class="text-muted mb-0">Administra los accesos y roles del sistema.</p>
        </div>
        <button type="button" class="btn btn-primary shadow-sm d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalUsuario">
            <i class="bi bi-person-plus-fill fs-5"></i>
            <span>Nuevo Usuario</span>
        </button>
    </div>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small fw-bold text-uppercase">Identificación</th>
                        <th class="py-3 text-secondary small fw-bold text-uppercase">Nombre Completo</th>
                        <th class="py-3 text-secondary small fw-bold text-uppercase">Email</th>
                        <th class="py-3 text-secondary small fw-bold text-uppercase">Rol</th>
                        <th class="py-3 text-secondary small fw-bold text-uppercase text-center">Estado</th>
                        <th class="pe-4 py-3 text-secondary small fw-bold text-uppercase text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php foreach($data['usuarios'] as $u): ?>
                    <tr>
                        <td class="ps-4 fw-semibold text-dark"><?= $u['identificacion'] ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                    <?= substr($u['nombres'], 0, 1) . substr($u['apellidos'], 0, 1) ?>
                                </div>
                                <?= $u['nombres'] . " " . $u['apellidos'] ?>
                            </div>
                        </td>
                        <td class="text-muted"><?= $u['email'] ?></td>
                        <td>
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                <?= $u['rol'] ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <?php if($u['estado'] == 'activo'): ?>
                                <span class="badge bg-success-subtle text-success px-3">Activo</span>
                            <?php else: ?>
                                <span class="badge bg-danger-subtle text-danger px-3">Inactivo</span>
                            <?php endif; ?>
                        </td>
                        <td class="pe-4 text-end">
                            <button class="btn btn-sm btn-light border" title="Editar"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-light border text-danger" title="Eliminar"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>