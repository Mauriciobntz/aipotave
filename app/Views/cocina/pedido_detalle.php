<div class="container mt-5">
    <h1 class="mb-4">
        <i class="fas fa-utensils me-2 text-warning"></i>Detalle de Pedido en Cocina
    </h1>

    <?php if (session('success')): ?>
        <div class="alert alert-success"><?= esc(session('success')) ?></div>
    <?php endif; ?>
    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <!-- Información del Pedido -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-info-circle me-2"></i>Información del Pedido #<?= esc($pedido['id']) ?>
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nombre del pedido:</strong> <?= esc($pedido['nombre'] ?? 'Pedido #' . $pedido['id']) ?></p>
                    <p><strong>Código de seguimiento:</strong> <?= esc($pedido['codigo_seguimiento']) ?></p>
                    <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?></p>
                    <p><strong>Método de pago:</strong> <?= ucfirst(esc($pedido['metodo_pago'])) ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Cliente:</strong> <?= esc($pedido['nombre']) ?></p>
                    <?php if (!empty($pedido['correo_electronico'])): ?>
                        <p><strong>Correo:</strong> <?= esc($pedido['correo_electronico']) ?></p>
                    <?php endif; ?>
                    <p><strong>Teléfono:</strong> <?= esc($pedido['cliente_telefono'] ?? 'No disponible') ?></p>
                    <p><strong>Dirección:</strong> <?= esc($pedido['direccion_entrega']) ?></p>
                    <p><strong>Estado actual:</strong> 
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
                    </p>
                </div>
            </div>
            <?php if ($pedido['observaciones']): ?>
                <div class="mt-3">
                    <strong>Observaciones:</strong>
                    <div class="alert alert-info mt-2">
                        <?= esc($pedido['observaciones']) ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Historial de Estados -->
    <?php if (!empty($historial)): ?>
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-history me-2"></i>Historial de Estados
            </h5>
        </div>
        <div class="card-body">
            <div class="timeline">
                <?php foreach ($historial as $index => $cambio): ?>
                    <div class="timeline-item">
                        <div class="timeline-marker <?= $index === 0 ? 'active' : '' ?>"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1"><?= ucfirst(esc($cambio['estado_nuevo'])) ?></h6>
                            <p class="text-muted mb-0"><?= date('d/m/Y H:i', strtotime($cambio['fecha_cambio'])) ?></p>
                            <?php if ($cambio['estado_anterior']): ?>
                                <small class="text-muted">Cambió de "<?= ucfirst(esc($cambio['estado_anterior'])) ?>" a "<?= ucfirst(esc($cambio['estado_nuevo'])) ?>"</small>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Detalle del pedido -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>Detalle del Pedido
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto/Combo</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        <?php foreach ($detalles as $item): ?>
                            <?php 
                            $nombre = '';
                            $imagen = '';
                            if ($item['producto_id']) {
                                $nombre = $item['producto_nombre'] ?? 'Producto #' . $item['producto_id'];
                                $imagen = $item['producto_imagen'] ?? '';
                            } else {
                                $nombre = $item['combo_nombre'] ?? 'Combo #' . $item['combo_id'];
                                $imagen = $item['combo_imagen'] ?? '';
                            }
                            $subtotal = $item['precio_unitario'] * $item['cantidad'];
                            $total += $subtotal;
                            ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if ($imagen): ?>
                                            <img src="<?= base_url('public/' . $imagen) ?>" alt="<?= esc($nombre) ?>" class="me-2" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                        <?php endif; ?>
                                        <div>
                                            <strong><?= esc($nombre) ?></strong>
                                            <?php if (!empty($item['observaciones'])): ?>
                                                <br><small class="text-muted"><?= esc($item['observaciones']) ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td><?= esc($item['cantidad']) ?></td>
                                <td>$<?= number_format($item['precio_unitario'], 2) ?></td>
                                <td>$<?= number_format($subtotal, 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total:</th>
                            <th>$<?= number_format($total, 2) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Acciones -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-cogs me-2"></i>Acciones
            </h5>
        </div>
        <div class="card-body">
            <div class="btn-group" role="group">
                <?php if ($pedido['estado'] == 'pendiente'): ?>
                    <button type="button" class="btn btn-info" onclick="cambiarEstado(<?= $pedido['id'] ?>, 'en_preparacion')">
                        <i class="fas fa-play me-2"></i>Iniciar Preparación
                    </button>
                <?php elseif ($pedido['estado'] == 'en_preparacion'): ?>
                    <button type="button" class="btn btn-success" onclick="cambiarEstado(<?= $pedido['id'] ?>, 'listo')">
                        <i class="fas fa-check me-2"></i>Marcar como Listo
                    </button>
                <?php endif; ?>
                <a href="<?= base_url('cocina/pedidos') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver al listado
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: #dee2e6;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-marker.active {
    background-color: #007bff;
    box-shadow: 0 0 0 2px #007bff;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -29px;
    top: 12px;
    width: 2px;
    height: calc(100% + 8px);
    background-color: #dee2e6;
}

.timeline-item:last-child::before {
    display: none;
}
</style>

<script>
function cambiarEstado(pedidoId, nuevoEstado) {
    const estados = {
        'en_preparacion': 'Iniciar Preparación',
        'listo': 'Marcar como Listo'
    };
    
    if (confirm('¿Estás seguro de cambiar el estado del pedido #' + pedidoId + ' a "' + estados[nuevoEstado] + '"?')) {
        fetch('<?= base_url('cocina/pedidos/cambiar-estado') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                pedido_id: pedidoId,
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
</script> 