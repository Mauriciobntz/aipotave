<div class="container mt-5">
    <h1 class="mb-4">
        <i class="fas fa-utensils me-2 text-warning"></i>Pedidos en Cocina
    </h1>

    <?php if (session('success')): ?>
        <div class="alert alert-success"><?= esc(session('success')) ?></div>
    <?php endif; ?>
    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h5>
        </div>
        <div class="card-body">
            <form method="get" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="pendiente" <?= ($estado_filtro == 'pendiente') ? 'selected' : '' ?>>Pendiente</option>
                        <option value="en_preparacion" <?= ($estado_filtro == 'en_preparacion') ? 'selected' : '' ?>>En Preparación</option>
                        <option value="listo" <?= ($estado_filtro == 'listo') ? 'selected' : '' ?>>Listo</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha Desde</label>
                    <input type="date" name="fecha_desde" class="form-control" value="<?= $fecha_desde ?? '' ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha Hasta</label>
                    <input type="date" name="fecha_hasta" class="form-control" value="<?= $fecha_hasta ?? '' ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Ordenar por</label>
                    <select name="orden" class="form-select">
                        <option value="fecha_desc" <?= ($orden == 'fecha_desc') ? 'selected' : '' ?>>Más recientes</option>
                        <option value="fecha_asc" <?= ($orden == 'fecha_asc') ? 'selected' : '' ?>>Más antiguos</option>
                        <option value="prioridad" <?= ($orden == 'prioridad') ? 'selected' : '' ?>>Por prioridad</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Filtrar
                    </button>
                    <a href="<?= base_url('cocina/pedidos') ?>" class="btn btn-outline-secondary ms-2">Limpiar filtros</a>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Pedido</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Observaciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td>
                            <strong>#<?= esc($pedido['id']) ?></strong>
                        </td>
                        <td>
                            <div>
                                <strong><?= esc($pedido['nombre'] ?? 'Pedido #' . $pedido['id']) ?></strong>
                                <?php if (!empty($pedido['codigo_seguimiento'])): ?>
                                    <br><small class="text-muted">Código: <?= esc($pedido['codigo_seguimiento']) ?></small>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <div>
                                <strong><?= esc($pedido['nombre']) ?></strong>
                                <?php if (!empty($pedido['celular'])): ?>
                                    <br><small class="text-muted">
                                        <i class="fas fa-phone me-1"></i><?= esc($pedido['celular']) ?>
                                    </small>
                                <?php endif; ?>
                                <?php if (!empty($pedido['correo_electronico'])): ?>
                                    <br><small class="text-muted">
                                        <i class="fas fa-envelope me-1"></i><?= esc($pedido['correo_electronico']) ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <div>
                                <strong><?= date('d/m/Y', strtotime($pedido['fecha'])) ?></strong>
                                <br><small class="text-muted"><?= date('H:i', strtotime($pedido['fecha'])) ?></small>
                            </div>
                        </td>
                        <td>
                            <?php 
                            $estadoClass = '';
                            $estadoText = '';
                            switch($pedido['estado']) {
                                case 'pendiente':
                                    $estadoClass = 'bg-warning text-dark';
                                    $estadoText = 'Pendiente';
                                    break;
                                case 'en_preparacion':
                                    $estadoClass = 'bg-info text-dark';
                                    $estadoText = 'En Preparación';
                                    break;
                                case 'listo':
                                    $estadoClass = 'bg-success';
                                    $estadoText = 'Listo';
                                    break;
                                default:
                                    $estadoClass = 'bg-secondary';
                                    $estadoText = ucfirst($pedido['estado']);
                            }
                            ?>
                            <span class="badge <?= $estadoClass ?> text-uppercase"><?= $estadoText ?></span>
                        </td>
                        <td>
                            <?php if (!empty($pedido['observaciones'])): ?>
                                <span class="text-muted"><?= esc(substr($pedido['observaciones'], 0, 50)) ?><?= strlen($pedido['observaciones']) > 50 ? '...' : '' ?></span>
                            <?php else: ?>
                                <span class="text-muted">Sin observaciones</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="<?= base_url('cocina/pedidos/' . $pedido['id']) ?>" class="btn btn-sm btn-primary" title="Ver detalle">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <?php if ($pedido['estado'] == 'pendiente'): ?>
                                    <button type="button" class="btn btn-sm btn-info" title="Iniciar preparación" onclick="cambiarEstado(<?= $pedido['id'] ?>, 'en_preparacion')">
                                        <i class="fas fa-play"></i>
                                    </button>
                                <?php elseif ($pedido['estado'] == 'en_preparacion'): ?>
                                    <button type="button" class="btn btn-sm btn-success" title="Marcar como listo" onclick="cambiarEstado(<?= $pedido['id'] ?>, 'listo')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                <?php endif; ?>
                                <button type="button" class="btn btn-sm btn-warning" title="Cambiar estado" onclick="mostrarModalEstado(<?= $pedido['id'] ?>, '<?= $pedido['estado'] ?>')">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if (empty($pedidos)): ?>
        <div class="text-center py-4">
            <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No hay pedidos pendientes</h5>
            <p class="text-muted">Todos los pedidos han sido procesados.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Modal para cambiar estado -->
<div class="modal fade" id="cambiarEstadoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Cambiar Estado del Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cambiarEstadoForm">
                    <input type="hidden" id="pedido_id_estado" name="pedido_id">
                    <div class="mb-3">
                        <label class="form-label">Nuevo Estado</label>
                        <select name="nuevo_estado" id="nuevo_estado_select" class="form-select" required>
                            <option value="">Selecciona un estado...</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="en_preparacion">En Preparación</option>
                            <option value="listo">Listo</option>
                            <option value="en_camino">En Camino</option>
                            <option value="entregado">Entregado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Observaciones (opcional)</label>
                        <textarea name="observaciones" class="form-control" rows="3" placeholder="Agregar observaciones sobre el cambio de estado..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="confirmarCambioEstado()">
                    <i class="fas fa-check me-2"></i>Cambiar Estado
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function cambiarEstado(pedidoId, nuevoEstado) {
    if (confirm('¿Estás seguro de cambiar el estado del pedido #' + pedidoId + ' a "' + nuevoEstado + '"?')) {
        fetch('<?= base_url('cocina/pedidos/cambiar-estado/') ?>' + pedidoId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                estado: nuevoEstado
            })
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
            alert('Error al cambiar el estado del pedido');
        });
    }
}

function mostrarModalEstado(pedidoId, estadoActual) {
    document.getElementById('pedido_id_estado').value = pedidoId;
    document.getElementById('nuevo_estado_select').value = '';
    document.querySelector('textarea[name="observaciones"]').value = '';
    
    // Mostrar el modal
    new bootstrap.Modal(document.getElementById('cambiarEstadoModal')).show();
}

function confirmarCambioEstado() {
    const formData = new FormData(document.getElementById('cambiarEstadoForm'));
    const pedidoId = formData.get('pedido_id');
    const nuevoEstado = formData.get('nuevo_estado');
    const observaciones = formData.get('observaciones');
    
    if (!nuevoEstado) {
        alert('Por favor selecciona un estado');
        return;
    }
    
    fetch('<?= base_url('cocina/pedidos/cambiar-estado/') ?>' + pedidoId, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            estado: nuevoEstado,
            observaciones: observaciones
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cerrar el modal
            bootstrap.Modal.getInstance(document.getElementById('cambiarEstadoModal')).hide();
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al cambiar el estado del pedido');
    });
}
</script> 