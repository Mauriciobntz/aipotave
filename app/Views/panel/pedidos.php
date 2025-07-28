<?= view('header', ['title' => 'Panel de Pedidos | Admin']) ?>
<?= view('navbar') ?>

<div class="container-fluid mt-4">
    <!-- Métricas rápidas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card-counter primary">
                <i class="fa fa-shopping-cart"></i>
                <span class="count-numbers"><?= $total_pedidos ?></span>
                <span class="count-name">Total Pedidos</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-counter warning">
                <i class="fa fa-clock"></i>
                <span class="count-numbers"><?= $pendientes ?></span>
                <span class="count-name">Pendientes</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-counter info">
                <i class="fa fa-utensils"></i>
                <span class="count-numbers"><?= $en_preparacion ?></span>
                <span class="count-name">En Preparación</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-counter success">
                <i class="fa fa-check-circle"></i>
                <span class="count-numbers"><?= $entregados_hoy ?></span>
                <span class="count-name">Entregados Hoy</span>
            </div>
        </div>
    </div>

    <!-- Alertas importantes -->
    <?php if ($pendientes > 0): ?>
    <div class="alert alert-warning alert-modern mb-4">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>¡Atención!</strong> Tienes <?= $pendientes ?> pedidos pendientes que requieren tu atención.
    </div>
    <?php endif; ?>

    <?php if ($en_preparacion > 0): ?>
    <div class="alert alert-info alert-modern mb-4">
        <i class="fas fa-utensils me-2"></i>
        <strong>En Cocina:</strong> <?= $en_preparacion ?> pedidos están siendo preparados.
    </div>
    <?php endif; ?>

    <!-- Filtros avanzados -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros Avanzados</h5>
        </div>
        <div class="card-body">
            <form method="get" class="row g-3">
                <div class="col-md-2">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos</option>
                        <option value="pendiente" <?= ($estado_filtro === 'pendiente') ? 'selected' : '' ?>>Pendiente</option>
                        <option value="confirmado" <?= ($estado_filtro === 'confirmado') ? 'selected' : '' ?>>Confirmado</option>
                        <option value="en_preparacion" <?= ($estado_filtro === 'en_preparacion') ? 'selected' : '' ?>>En Preparación</option>
                        <option value="listo" <?= ($estado_filtro === 'listo') ? 'selected' : '' ?>>Listo</option>
                        <option value="en_camino" <?= ($estado_filtro === 'en_camino') ? 'selected' : '' ?>>En Camino</option>
                        <option value="entregado" <?= ($estado_filtro === 'entregado') ? 'selected' : '' ?>>Entregado</option>
                        <option value="cancelado" <?= ($estado_filtro === 'cancelado') ? 'selected' : '' ?>>Cancelado</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Método de Pago</label>
                    <select name="metodo_pago" class="form-select">
                        <option value="">Todos</option>
                        <option value="efectivo" <?= ($metodo_filtro === 'efectivo') ? 'selected' : '' ?>>Efectivo</option>
                        <option value="tarjeta" <?= ($metodo_filtro === 'tarjeta') ? 'selected' : '' ?>>Tarjeta</option>
                        <option value="transferencia" <?= ($metodo_filtro === 'transferencia') ? 'selected' : '' ?>>Transferencia</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Fecha Desde</label>
                    <input type="date" name="fecha_desde" class="form-control" value="<?= $fecha_desde ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Fecha Hasta</label>
                    <input type="date" name="fecha_hasta" class="form-control" value="<?= $fecha_hasta ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Buscar</label>
                    <input type="text" name="buscar" class="form-control" placeholder="Cliente, código..." value="<?= $buscar ?>">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-modern w-100">
                        <i class="fas fa-search me-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de pedidos -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Pedidos</h5>
            <div>
                <span class="badge bg-primary"><?= count($pedidos) ?> resultados</span>
            </div>
        </div>
        <div class="card-body">
            <?php if (empty($pedidos)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No hay pedidos que coincidan con los filtros</h5>
                    <p class="text-muted">Intenta ajustar los filtros o crear un nuevo pedido</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th><i class="fas fa-hashtag me-2"></i>ID</th>
                                <th><i class="fas fa-calendar me-2"></i>Fecha</th>
                                <th><i class="fas fa-user me-2"></i>Cliente</th>
                                <th><i class="fas fa-phone me-2"></i>Teléfono</th>
                                <th><i class="fas fa-map-marker-alt me-2"></i>Dirección</th>
                                <th><i class="fas fa-dollar-sign me-2"></i>Total</th>
                                <th><i class="fas fa-credit-card me-2"></i>Pago</th>
                                <th><i class="fas fa-info-circle me-2"></i>Estado</th>
                                <th><i class="fas fa-comment me-2"></i>Observaciones</th>
                                <th><i class="fas fa-cogs me-2"></i>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedidos as $pedido): ?>
                                <tr>
                                    <td>
                                        <strong>#<?= $pedido['id'] ?></strong>
                                        <br><small class="text-muted"><?= $pedido['codigo_seguimiento'] ?></small>
                                    </td>
                                    <td>
                                        <?= date('d/m/Y', strtotime($pedido['fecha'])) ?>
                                        <br><small class="text-muted"><?= date('H:i', strtotime($pedido['fecha'])) ?></small>
                                    </td>
                                    <td>
                                        <strong><?= esc($pedido['nombre']) ?></strong>
                                        <?php if (!empty($pedido['correo_electronico'])): ?>
                                            <br><small class="text-muted"><?= esc($pedido['correo_electronico']) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($pedido['celular'])): ?>
                                            <i class="fas fa-phone me-1"></i><?= esc($pedido['celular']) ?>
                                        <?php else: ?>
                                            <span class="text-muted">Sin celular</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($pedido['direccion_entrega'])): ?>
                                            <i class="fas fa-map-marker-alt me-1"></i><?= esc($pedido['direccion_entrega']) ?>
                                        <?php else: ?>
                                            <span class="text-muted">Sin dirección</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong class="text-success">$<?= number_format($pedido['total'], 0, ',', '.') ?></strong>
                                    </td>
                                    <td>
                                        <?php
                                        $metodo_colores = [
                                            'efectivo' => 'bg-success',
                                            'tarjeta' => 'bg-primary',
                                            'transferencia' => 'bg-info'
                                        ];
                                        $color = $metodo_colores[$pedido['metodo_pago']] ?? 'bg-secondary';
                                        ?>
                                        <span class="badge <?= $color ?>"><?= ucfirst($pedido['metodo_pago']) ?></span>
                                    </td>
                                    <td>
                                        <?php
                                        $estado_colores = [
                                            'pendiente' => 'badge-pending',
                                            'confirmado' => 'badge-info',
                                            'en_preparacion' => 'badge-preparing',
                                            'listo' => 'badge-warning',
                                            'en_camino' => 'badge-delivery',
                                            'entregado' => 'badge-delivered',
                                            'cancelado' => 'badge-cancelled'
                                        ];
                                        $estado_clase = $estado_colores[$pedido['estado']] ?? 'badge-secondary';
                                        ?>
                                        <span class="badge <?= $estado_clase ?>"><?= ucfirst(str_replace('_', ' ', $pedido['estado'])) ?></span>
                                    </td>
                                    <td>
                                        <?php if (!empty($pedido['observaciones'])): ?>
                                            <span class="text-truncate d-inline-block" style="max-width: 150px;" title="<?= esc($pedido['observaciones']) ?>">
                                                <?= esc(substr($pedido['observaciones'], 0, 50)) ?><?= strlen($pedido['observaciones']) > 50 ? '...' : '' ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">Sin observaciones</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('admin/pedidos/' . $pedido['id']) ?>" class="btn btn-sm btn-outline-primary btn-modern" title="Ver detalle">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <?php if ($pedido['estado'] === 'listo' && empty($pedido['repartidor_id'])): ?>
                                                <button class="btn btn-sm btn-outline-success btn-modern" title="Asignar repartidor" onclick="asignarRepartidor(<?= $pedido['id'] ?>)">
                                                    <i class="fas fa-motorcycle"></i>
                                                </button>
                                            <?php endif; ?>
                                            <?php if (in_array($pedido['estado'], ['pendiente', 'confirmado'])): ?>
                                                <button class="btn btn-sm btn-outline-warning btn-modern" title="Cambiar estado" onclick="cambiarEstado(<?= $pedido['id'] ?>)">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal para asignar repartidor -->
<div class="modal fade" id="asignarRepartidorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-motorcycle me-2"></i>Asignar Repartidor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="asignarRepartidorForm">
                    <input type="hidden" id="pedido_id" name="pedido_id">
                    <div class="mb-3">
                        <label class="form-label">Seleccionar Repartidor</label>
                        <select name="repartidor_id" class="form-select" required>
                            <option value="">Selecciona un repartidor...</option>
                            <?php foreach ($repartidores as $repartidor): ?>
                                <option value="<?= $repartidor['id'] ?>">
                                    <?= esc($repartidor['nombre']) ?> - <?= esc($repartidor['vehiculo']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-modern" onclick="confirmarAsignacion()">
                    <i class="fas fa-check me-2"></i>Asignar
                </button>
            </div>
        </div>
    </div>
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
                        <select name="nuevo_estado" class="form-select" required>
                            <option value="">Selecciona un estado...</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="confirmado">Confirmado</option>
                            <option value="en_preparacion">En Preparación</option>
                            <option value="listo">Listo</option>
                            <option value="en_camino">En Camino</option>
                            <option value="entregado">Entregado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-modern" onclick="confirmarCambioEstado()">
                    <i class="fas fa-check me-2"></i>Cambiar Estado
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function asignarRepartidor(pedidoId) {
    document.getElementById('pedido_id').value = pedidoId;
    new bootstrap.Modal(document.getElementById('asignarRepartidorModal')).show();
}

function confirmarAsignacion() {
    const formData = new FormData(document.getElementById('asignarRepartidorForm'));
    
    fetch('<?= base_url('admin/asignar-repartidor') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error al asignar repartidor: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al asignar repartidor');
    });
}

function cambiarEstado(pedidoId) {
    document.getElementById('pedido_id_estado').value = pedidoId;
    new bootstrap.Modal(document.getElementById('cambiarEstadoModal')).show();
}

function confirmarCambioEstado() {
    const formData = new FormData(document.getElementById('cambiarEstadoForm'));
    
    fetch('<?= base_url('admin/cambiar-estado') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error al cambiar estado: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al cambiar estado');
    });
}
</script>

<?= view('footer') ?> 