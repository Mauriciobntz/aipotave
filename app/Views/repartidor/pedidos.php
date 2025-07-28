<div class="container mt-5">
    <h1 class="mb-4">
        <i class="fas fa-motorcycle me-2 text-primary"></i>Mis Pedidos
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
                        <option value="en_camino" <?= ($estado_filtro == 'en_camino') ? 'selected' : '' ?>>En Camino</option>
                        <option value="entregado" <?= ($estado_filtro == 'entregado') ? 'selected' : '' ?>>Entregado</option>
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
                    <a href="<?= base_url('repartidor/pedidos') ?>" class="btn btn-outline-secondary ms-2">Limpiar filtros</a>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Dirección</th>
                    <th>Total</th>
                    <th>Método Pago</th>
                    <th>Estado Pago</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Monitoreo</th>
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
                                <strong><?= esc($pedido['direccion_entrega']) ?></strong>
                                <?php if (!empty($pedido['observaciones'])): ?>
                                    <br><small class="text-muted"><?= esc(substr($pedido['observaciones'], 0, 50)) ?><?= strlen($pedido['observaciones']) > 50 ? '...' : '' ?></small>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <div>
                                <strong><?= esc($pedido['total']) ?></strong>
                            </div>
                        </td>
                        <td>
                            <div>
                                <strong><?= esc($pedido['metodo_pago']) ?></strong>
                            </div>
                        </td>
                        <td>
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
                            <span class="badge <?= $estadoPagoClass ?> text-uppercase"><?= $estadoPagoText ?></span>
                        </td>
                        <td>
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
                        </td>
                        <td>
                            <div>
                                <strong><?= date('d/m/Y', strtotime($pedido['fecha'])) ?></strong>
                                <br><small class="text-muted"><?= date('H:i', strtotime($pedido['fecha'])) ?></small>
                            </div>
                        </td>
                        <td>
                            <?php if ($pedido['estado'] == 'en_camino'): ?>
                                <span class="badge bg-success">
                                    <i class="fas fa-satellite-dish me-1"></i>Activo
                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary">
                                    <i class="fas fa-pause me-1"></i>Inactivo
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="<?= base_url('repartidor/pedidos/' . $pedido['id']) ?>" class="btn btn-sm btn-primary" title="Ver detalle">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            onclick="cambiarEstado(<?= $pedido['id'] ?>, 'entregado')">
                                        <i class="fas fa-check me-1"></i>Entregado
                                    </button>
                                    <?php if ($pedido['estado_pago'] == 'pendiente' && $pedido['metodo_pago'] == 'efectivo'): ?>
                                        <button type="button" class="btn btn-sm btn-outline-success" 
                                                onclick="marcarPagoRecibido(<?= $pedido['id'] ?>)">
                                            <i class="fas fa-money-bill me-1"></i>Cobrado
                                        </button>
                                    <?php endif; ?>
                                </div>
                                <button type="button" class="btn btn-sm btn-info" title="Ver dirección de envío" onclick="verDireccionEnvio(<?= $pedido['id'] ?>, '<?= esc($pedido['direccion_entrega']) ?>')">
                                    <i class="fas fa-map-marker-alt"></i>
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
            <i class="fas fa-motorcycle fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No hay pedidos asignados</h5>
            <p class="text-muted">No tienes pedidos pendientes de entrega.</p>
        </div>
    <?php endif; ?>
</div>

<script>
        // Registrar Service Worker para ubicación en segundo plano
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js')
                .then(function(registration) {
                    // Service Worker registrado correctamente
                })
                .catch(function(error) {
                    // Error al registrar Service Worker
                });
        }

let ultimaUbicacion = null;
let watchId = null;
let pedidosActivos = [];
let monitoreoActivo = false;

// Función para calcular distancia entre dos puntos
function calcularDistancia(lat1, lon1, lat2, lon2) {
    const R = 6371; // Radio de la Tierra en km
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
              Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
              Math.sin(dLon/2) * Math.sin(dLon/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c * 1000; // Distancia en metros
}

// Función para verificar si el cambio es significativo (más de 50 metros)
function esCambioSignificativo(nuevaLat, nuevaLon) {
    if (!ultimaUbicacion) return true;
    
    const distancia = calcularDistancia(
        ultimaUbicacion.latitud,
        ultimaUbicacion.longitud,
        nuevaLat,
        nuevaLon
    );
    
    return distancia > 50; // 50 metros
}

// Función para actualizar ubicación usando Service Worker si está disponible
function actualizarUbicacionConSW(pedidoId, latitud, longitud) {
    if ('serviceWorker' in navigator && navigator.serviceWorker.controller) {
        // Enviar mensaje al Service Worker
        navigator.serviceWorker.controller.postMessage({
            type: 'ACTUALIZAR_UBICACION',
            pedidoId: pedidoId,
            latitud: latitud,
            longitud: longitud
        });
    } else {
        // Fallback: actualización directa
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
                ultimaUbicacion = { latitud: latitud, longitud: longitud };
            } else {
                // Error en la respuesta del servidor
            }
        })
        .catch(error => {
            // Error de red
        });
    }
}

// Función para actualizar ubicación de forma inteligente
function actualizarUbicacionInteligente(pedidoId) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const nuevaLat = position.coords.latitude;
            const nuevaLon = position.coords.longitude;
            
            // Solo actualizar si hay cambio significativo
            if (esCambioSignificativo(nuevaLat, nuevaLon)) {
                actualizarUbicacionConSW(pedidoId, nuevaLat, nuevaLon);
            }
        }, function(error) {
            // Error al obtener ubicación:
        }, {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 30000
        });
    }
}

// Función para iniciar monitoreo de ubicación
function iniciarMonitoreoUbicacion(pedidoId) {
    if (watchId) {
        navigator.geolocation.clearWatch(watchId);
    }
    
    monitoreoActivo = true;
    
    watchId = navigator.geolocation.watchPosition(
        function(position) {
            const nuevaLat = position.coords.latitude;
            const nuevaLon = position.coords.longitude;
            
            if (esCambioSignificativo(nuevaLat, nuevaLon)) {
                actualizarUbicacionConSW(pedidoId, nuevaLat, nuevaLon);
            }
        },
        function(error) {
            // Error en monitoreo de ubicación:
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 30000
        }
    );
}

// Función para detener monitoreo
function detenerMonitoreoUbicacion() {
    if (watchId) {
        navigator.geolocation.clearWatch(watchId);
        watchId = null;
        monitoreoActivo = false;
    }
}

function cambiarEstado(pedidoId, nuevoEstado) {
    if (confirm('¿Estás seguro de marcar el pedido #' + pedidoId + ' como entregado?')) {
        // Detener monitoreo si el pedido se marca como entregado
        if (nuevoEstado === 'entregado') {
            detenerMonitoreoUbicacion();
        }
        
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
            // Error al cambiar el estado del pedido
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
                    ultimaUbicacion = { latitud: latitud, longitud: longitud };
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                // Error al actualizar la ubicación
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

function marcarPagoRecibido(pedidoId) {
    if (confirm('¿Estás seguro de marcar el pago del pedido #' + pedidoId + ' como recibido?')) {
        fetch('<?= base_url('repartidor/pedidos/marcar-pago-recibido') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                pedido_id: pedidoId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Pago marcado como recibido para el pedido #' + pedidoId);
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

// Iniciar monitoreo automático cuando la página carga
document.addEventListener('DOMContentLoaded', function() {
    // Obtener pedidos activos (en_camino)
    const pedidosEnCamino = <?= json_encode(array_filter($pedidos, function($p) { return $p['estado'] == 'en_camino'; })) ?>;
    
    if (pedidosEnCamino.length > 0) {
        // Iniciar monitoreo para el primer pedido en camino
        const primerPedido = pedidosEnCamino[0];
        iniciarMonitoreoUbicacion(primerPedido.id);
        
        // Mostrar indicador de monitoreo activo
        const indicador = document.createElement('div');
        indicador.id = 'monitoreo-indicador';
        indicador.innerHTML = `
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-map-marker-alt me-2"></i>
                <strong>Monitoreo activo:</strong> Ubicación actualizándose automáticamente
                <small class="d-block mt-1">Funciona incluso con la app en segundo plano</small>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        document.querySelector('.container').insertBefore(indicador, document.querySelector('.container').firstChild);
    }
});

// Manejar cambios de visibilidad de la página
document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
        // Página oculta, monitoreo continúa en segundo plano
        // El Service Worker mantiene el monitoreo activo
    } else {
        // Página visible, monitoreo activo
    }
});

// Detener monitoreo antes de cerrar la página
window.addEventListener('beforeunload', function() {
    detenerMonitoreoUbicacion();
});

// Manejar cuando la página vuelve a estar activa
window.addEventListener('focus', function() {
    if (monitoreoActivo) {
        // Página activa, monitoreo continúa
    }
});
</script> 