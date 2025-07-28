<div class="container mt-5">
    <h1 class="mb-4">
        <i class="fas fa-motorcycle me-2 text-primary"></i>Detalle de Pedido
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
                    <p><strong>Cliente:</strong> <?= esc($pedido['cliente_nombre'] ?? 'Cliente #' . $pedido['usuario_id']) ?></p>
                    <p><strong>Teléfono:</strong> <?= esc($pedido['cliente_telefono'] ?? 'No disponible') ?></p>
                    <p><strong>Dirección:</strong> <?= esc($pedido['direccion_entrega']) ?></p>
                    <p><strong>Estado actual:</strong> 
                        <?php 
                        $estadoClass = '';
                        $estadoText = '';
                        switch($pedido['estado']) {
                            case 'en_camino':
                                $estadoClass = 'bg-primary';
                                $estadoText = 'En Camino';
                                break;
                            case 'entregado':
                                $estadoClass = 'bg-success';
                                $estadoText = 'Entregado';
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

    <!-- Última Ubicación -->
    <?php if (!empty($ultima_ubicacion)): ?>
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-map-marker-alt me-2 text-danger"></i>Última Ubicación Registrada
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Latitud:</strong> <?= esc($ultima_ubicacion['latitud']) ?></p>
                    <p><strong>Longitud:</strong> <?= esc($ultima_ubicacion['longitud']) ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($ultima_ubicacion['fecha'])) ?></p>
                    <div class="alert alert-success alert-sm">
                        <i class="fas fa-sync-alt me-2"></i>
                        <small>La ubicación se actualiza automáticamente</small>
                    </div>
                </div>
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
            <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Estado del Pedido:</strong>
                            <span class="badge bg-primary ms-2"><?= ucfirst($pedido['estado']) ?></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Estado del Pago:</strong>
                            <?php 
                            $estadoPagoClass = '';
                            $estadoPagoText = '';
                            switch($pedido['estado_pago']) {
                                case 'pagado':
                                    $estadoPagoClass = 'bg-success';
                                    $estadoPagoText = 'Pagado';
                                    break;
                                case 'pendiente':
                                    $estadoPagoClass = 'bg-warning';
                                    $estadoPagoText = 'Pendiente';
                                    break;
                                case 'devuelto':
                                    $estadoPagoClass = 'bg-danger';
                                    $estadoPagoText = 'Devuelto';
                                    break;
                                default:
                                    $estadoPagoClass = 'bg-secondary';
                                    $estadoPagoText = ucfirst($pedido['estado_pago']);
                            }
                            ?>
                            <span class="badge <?= $estadoPagoClass ?> ms-2"><?= $estadoPagoText ?></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Cliente:</strong>
                            <div><?= esc($pedido['nombre']) ?></div>
                            <?php if (!empty($pedido['correo_electronico'])): ?>
                                <small class="text-muted"><?= esc($pedido['correo_electronico']) ?></small>
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
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-success" onclick="cambiarEstado('entregado')">
                    <i class="fas fa-check me-2"></i>Marcar como Entregado
                </button>
                <?php if ($pedido['estado_pago'] == 'pendiente' && $pedido['metodo_pago'] == 'efectivo'): ?>
                    <button type="button" class="btn btn-warning" onclick="marcarPagoRecibido()">
                        <i class="fas fa-money-bill me-2"></i>Marcar Pago Recibido
                    </button>
                <?php endif; ?>
                <button type="button" class="btn btn-info" onclick="verDireccionEnvio()">
                    <i class="fas fa-map-marker-alt me-2"></i>Ver Dirección de Envío
                </button>
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
    if (confirm('¿Estás seguro de marcar el pedido #' + pedidoId + ' como entregado?')) {
        fetch('<?= base_url('repartidor/pedidos/cambiar-estado') ?>', {
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

function actualizarUbicacion(pedidoId) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const latitud = position.coords.latitude;
            const longitud = position.coords.longitude;
            
            fetch('<?= base_url('repartidor/pedidos/actualizar-ubicacion') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    pedido_id: pedidoId,
                    latitud: latitud,
                    longitud: longitud
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Ubicación actualizada correctamente');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al actualizar la ubicación');
            });
        }, function(error) {
            alert('Error al obtener la ubicación: ' + error.message);
        });
    } else {
        alert('La geolocalización no está disponible en este navegador');
    }
}

function verDireccionEnvio(pedidoId, direccion) {
    if (direccion && direccion.trim() !== '') {
        // Abrir Google Maps con la dirección
        const url = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(direccion)}`;
        window.open(url, '_blank');
        
        // También mostrar un modal con la información
        mostrarModalDireccion(pedidoId, direccion);
    } else {
        alert('No hay dirección de envío disponible para este pedido.');
    }
}

function mostrarModalDireccion(pedidoId, direccion) {
    // Crear modal dinámicamente si no existe
    let modal = document.getElementById('modalDireccion');
    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'modalDireccion';
        modal.className = 'modal fade';
        modal.innerHTML = `
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                            Dirección de Envío
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <strong>Pedido #<span id="pedidoIdModal"></span></strong>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-map-marker-alt me-2"></i>Dirección:</label>
                            <p class="form-control-plaintext" id="direccionModal"></p>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <small>La ubicación se actualiza automáticamente mientras te diriges al destino.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="abrirGoogleMaps()">
                            <i class="fas fa-external-link-alt me-2"></i>Abrir en Google Maps
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    }
    
    // Actualizar contenido del modal
    document.getElementById('pedidoIdModal').textContent = pedidoId;
    document.getElementById('direccionModal').textContent = direccion;
    
    // Mostrar modal
    const modalInstance = new bootstrap.Modal(modal);
    modalInstance.show();
}

function abrirGoogleMaps() {
    const direccion = document.getElementById('direccionModal').textContent;
    const url = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(direccion)}`;
    window.open(url, '_blank');
}

function marcarPagoRecibido() {
    if (confirm('¿Estás seguro de marcar el pago del pedido #<?= $pedido['id'] ?> como recibido?')) {
        fetch('<?= base_url('repartidor/pedidos/marcar-pago-recibido') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                pedido_id: <?= $pedido['id'] ?>
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Pago marcado como recibido para el pedido #<?= $pedido['id'] ?>');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error al marcar el pago como recibido');
        });
    }
}
</script> 