<?php
// Verificar si hay mensajes de sesión
$success = session()->getFlashdata('success');
$error = session()->getFlashdata('error');
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-truck me-2"></i>Tarifas Locales de Envío
                    </h5>
                    <a href="<?= base_url('admin/tarifas-envio/crear') ?>" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-1"></i>Nueva Tarifa Local
                    </a>
                </div>
                
                <div class="card-body">
                    <!-- Filtros -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form method="GET" class="d-flex">
                                <input type="text" name="nombre" class="form-control me-2" 
                                       placeholder="Buscar por nombre..." 
                                       value="<?= $request->getGet('nombre') ?>">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form method="GET" class="d-flex">
                                <select name="activo" class="form-select me-2">
                                    <option value="">Todos los estados</option>
                                    <option value="1" <?= $request->getGet('activo') === '1' ? 'selected' : '' ?>>Activo</option>
                                    <option value="0" <?= $request->getGet('activo') === '0' ? 'selected' : '' ?>>Inactivo</option>
                                </select>
                                <button type="submit" class="btn btn-outline-secondary">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Mensajes -->
                    <?php if ($success): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?= $success ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i><?= $error ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Tabla de tarifas -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Orden</th>
                                    <th>Nombre</th>
                                    <th>Rango de Distancia</th>
                                    <th>Costo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($tarifas)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fas fa-truck fa-2x text-muted mb-3 d-block"></i>
                                            <p class="text-muted">No hay tarifas locales de envío configuradas</p>
                                            <a href="<?= base_url('admin/tarifas-envio/crear') ?>" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus me-1"></i>Crear Primera Tarifa Local
                                            </a>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($tarifas as $tarifa): ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-secondary"><?= $tarifa['orden'] ?></span>
                                            </td>
                                            <td>
                                                <strong><?= esc($tarifa['nombre']) ?></strong>
                                                <?php if ($tarifa['descripcion']): ?>
                                                    <br><small class="text-muted"><?= esc($tarifa['descripcion']) ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?= number_format($tarifa['distancia_minima'], 1) ?> - 
                                                    <?= number_format($tarifa['distancia_maxima'], 1) ?> km
                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-success">
                                                    $<?= number_format($tarifa['costo'], 0, ',', '.') ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge <?= $tarifa['activo'] ? 'bg-success' : 'bg-danger' ?>">
                                                    <?= $tarifa['activo'] ? 'Activo' : 'Inactivo' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="<?= base_url('admin/tarifas-envio/editar/' . $tarifa['id']) ?>" 
                                                       class="btn btn-outline-primary" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-outline-<?= $tarifa['activo'] ? 'warning' : 'success' ?>"
                                                            onclick="cambiarEstado(<?= $tarifa['id'] ?>, <?= $tarifa['activo'] ?>)"
                                                            title="<?= $tarifa['activo'] ? 'Desactivar' : 'Activar' ?>">
                                                        <i class="fas fa-<?= $tarifa['activo'] ? 'eye-slash' : 'eye' ?>"></i>
                                                    </button>
                                                    <button type="button" 
                                                            class="btn btn-outline-danger"
                                                            onclick="confirmarEliminar(<?= $tarifa['id'] ?>, '<?= esc($tarifa['nombre']) ?>')"
                                                            title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <?php if (isset($paginas) && $paginas > 1): ?>
                        <nav aria-label="Paginación de tarifas">
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $paginas; $i++): ?>
                                    <li class="page-item <?= $i == $pagina_actual ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>&nombre=<?= urlencode($request->getGet('nombre') ?? '') ?>&activo=<?= $request->getGet('activo') ?? '' ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEliminarLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que quieres eliminar la tarifa local "<strong id="nombreTarifa"></strong>"?</p>
                <p class="text-danger"><small>Esta acción no se puede deshacer.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="btnEliminar" class="btn btn-danger">
                    <i class="fas fa-trash me-1"></i>Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function cambiarEstado(id, estadoActual) {
    const nuevoEstado = estadoActual ? 0 : 1;
    const accion = estadoActual ? 'desactivar' : 'activar';
    
    if (confirm(`¿Estás seguro de que quieres ${accion} esta tarifa local de envío?`)) {
        fetch(`<?= base_url('admin/tarifas-envio/cambiar-estado') ?>/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cambiar el estado');
        });
    }
}

function confirmarEliminar(id, nombre) {
    document.getElementById('nombreTarifa').textContent = nombre;
    
    // Mostrar el modal
    const modal = new bootstrap.Modal(document.getElementById('modalEliminar'));
    modal.show();
    
    // Agregar evento al botón de eliminar
    document.getElementById('btnEliminar').onclick = function() {
        window.location.href = `<?= base_url('admin/tarifas-envio/eliminar') ?>/${id}`;
    };
}
</script>
