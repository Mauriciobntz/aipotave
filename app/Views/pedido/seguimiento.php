<div class="container mt-5">
    <h1 class="mb-4">
        <i class="fas fa-truck me-2 text-primary"></i>Seguimiento de Pedido
    </h1>
    
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-info-circle me-2"></i>Información del Pedido
            </h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Cliente:</strong>
                    <div><?= esc($pedido['nombre']) ?></div>
                    <?php if (isset($pedido['celular']) && $pedido['celular'] !== ''): ?>
                        <small class="text-muted">
                            <i class="fas fa-phone me-1"></i><?= esc($pedido['celular']) ?>
                        </small>
                    <?php else: ?>
                        <small class="text-muted">
                            <i class="fas fa-phone me-1"></i>No disponible
                        </small>
                    <?php endif; ?>
                    <?php if (!empty($pedido['correo_electronico'])): ?>
                        <br><small class="text-muted">
                            <i class="fas fa-envelope me-1"></i><?= esc($pedido['correo_electronico']) ?>
                        </small>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <strong>Dirección de Entrega:</strong>
                    <div><?= esc($pedido['direccion_entrega']) ?></div>
                    <?php if (!empty($pedido['entre'])): ?>
                        <small class="text-muted">Entre: <?= esc($pedido['entre']) ?></small>
                    <?php endif; ?>
                    <?php if (!empty($pedido['indicacion'])): ?>
                        <br><small class="text-muted">Indicación: <?= esc($pedido['indicacion']) ?></small>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Código de seguimiento:</strong> <span class="badge bg-primary"><?= esc($pedido['codigo_seguimiento']) ?></span></p>
                    <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?></p>
                    <p><strong>Método de pago:</strong> <?= ucfirst(esc($pedido['metodo_pago'])) ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Estado actual:</strong> 
                        <?php 
                        $estadoClass = '';
                        $estadoText = '';
                        switch($pedido['estado']) {
                            case 'pendiente':
                                $estadoClass = 'bg-warning text-dark';
                                $estadoText = 'Pendiente';
                                break;
                            case 'confirmado':
                                $estadoClass = 'bg-info text-dark';
                                $estadoText = 'Confirmado';
                                break;
                            case 'en_preparacion':
                                $estadoClass = 'bg-info text-dark';
                                $estadoText = 'En Preparación';
                                break;
                            case 'listo':
                                $estadoClass = 'bg-success';
                                $estadoText = 'Listo';
                                break;
                            case 'en_camino':
                                $estadoClass = 'bg-primary';
                                $estadoText = 'En Camino';
                                break;
                            case 'entregado':
                                $estadoClass = 'bg-success';
                                $estadoText = 'Entregado';
                                break;
                            case 'cancelado':
                                $estadoClass = 'bg-danger';
                                $estadoText = 'Cancelado';
                                break;
                            default:
                                $estadoClass = 'bg-secondary';
                                $estadoText = ucfirst($pedido['estado']);
                        }
                        ?>
                        <span class="badge <?= $estadoClass ?> text-uppercase"><?= $estadoText ?></span>
                    </p>
                    <?php if (!empty($pedido['repartidor_nombre'])): ?>
                        <p><strong>Repartidor:</strong> <?= esc($pedido['repartidor_nombre']) ?></p>
                    <?php endif; ?>
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
            
            <?php if ($pedido['estado'] === 'cancelado'): ?>
                <div class="alert alert-danger mt-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>Este pedido fue cancelado.
                </div>
            <?php elseif ($pedido['estado'] === 'entregado'): ?>
                <div class="alert alert-success mt-3">
                    <i class="fas fa-check-circle me-2"></i>¡Pedido entregado! ¡Gracias por tu compra!
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

    <!-- Calificación -->
    <?php if ($pedido['estado'] === 'entregado' && !empty($calificacion)): ?>
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-star me-2 text-warning"></i>Tu Calificación
            </h5>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fas fa-star <?= $i <= $calificacion['puntuacion'] ? 'text-warning' : 'text-muted' ?>"></i>
                    <?php endfor; ?>
                </div>
                <div>
                    <strong><?= $calificacion['puntuacion'] ?>/5 estrellas</strong>
                    <?php if (!empty($calificacion['comentario'])): ?>
                        <br><small class="text-muted"><?= esc($calificacion['comentario']) ?></small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php elseif ($pedido['estado'] === 'entregado' && empty($calificacion)): ?>
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-star me-2 text-warning"></i>Califica tu Pedido
            </h5>
        </div>
        <div class="card-body">
            <p class="mb-3">¿Cómo fue tu experiencia con este pedido?</p>
            <a href="<?= base_url('calificacion/' . $pedido['id']) ?>" class="btn btn-warning">
                <i class="fas fa-star me-2"></i>Calificar Pedido
            </a>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($pedido['repartidor_id'])): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-map-marker-alt me-2 text-danger"></i>Ubicación del Repartidor
                </h5>
            </div>
            <div class="card-body">
                <div id="map" style="height: 350px;" class="mb-3"></div>
                <small class="text-muted">La ubicación se actualiza automáticamente cada 10 segundos</small>
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
                            <th>Precio unitario</th>
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

    <div class="text-center">
        <a href="<?= base_url('/') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver al menú principal
        </a>
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

<?php if (!empty($pedido['repartidor_id'])): ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script>
const repartidorId = <?= json_encode($pedido['repartidor_id']) ?>;
const pedidoId = <?= json_encode($pedido['id']) ?>;
let map = L.map('map').setView([-34.6, -58.4], 13); // Centrado inicial (puedes ajustar)
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap'
}).addTo(map);
let marker = null;

function actualizarUbicacion() {
    fetch('<?= base_url('api/ubicacion') ?>/' + repartidorId + '/' + pedidoId)
        .then(res => res.json())
        .then(data => {
            if (data.latitud && data.longitud) {
                const latlng = [parseFloat(data.latitud), parseFloat(data.longitud)];
                if (!marker) {
                    marker = L.marker(latlng).addTo(map).bindPopup('Repartidor');
                    map.setView(latlng, 15);
                } else {
                    marker.setLatLng(latlng);
                }
            }
        })
        .catch(error => {
            console.error('Error al obtener ubicación:', error);
        });
}

actualizarUbicacion();
setInterval(actualizarUbicacion, 10000); // Actualiza cada 10 segundos
</script>
<?php endif; ?> 