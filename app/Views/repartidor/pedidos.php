<div class="container-fluid mt-3">
    <!-- Header móvil -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            <i class="fas fa-motorcycle text-primary me-2"></i>Mis Pedidos
        </h4>
    </div>

    <!-- Mapa compacto para móvil -->
    <div class="card mb-3">
        <div class="card-header py-2">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-map-marked-alt me-2"></i>Mapa de Pedidos</h6>
                <div class="btn-group btn-group-sm">
                    <button onclick="limpiarRutas()" class="btn btn-outline-secondary btn-sm" title="Limpiar rutas">
                        <i class="fas fa-eraser"></i>
                    </button>
                    <button onclick="toggleMonitoreo()" class="btn btn-outline-info btn-sm" id="btn-monitoreo" title="Activar/Desactivar monitoreo">
                        <i class="fas fa-satellite-dish"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-2">
            <div id="map" style="height: 250px; width: 100%; border-radius: 8px;"></div>
            <div id="map-error" class="alert alert-warning mt-2 py-2" style="display: none; font-size: 0.9rem;">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Error del mapa:</strong> <span id="error-message"></span>
            </div>
            <!-- Información de ruta -->
            <div id="route-info" class="mt-2 p-2 bg-light rounded" style="display: none;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Ruta activa:</small>
                        <div id="route-details" class="small"></div>
                    </div>
                    <button onclick="limpiarRutas()" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- Estado del monitoreo -->
            <div id="monitoreo-status" class="mt-2 p-2 bg-success text-white rounded" style="display: none;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-satellite-dish me-2"></i>
                    <div>
                        <small><strong>Monitoreo Activo</strong></small>
                        <div class="small">Tu ubicación se actualiza automáticamente para que los clientes puedan seguirte en tiempo real</div>
                    </div>
                </div>
            </div>
            
            <!-- Estado del Service Worker -->
            <div id="sw-status" class="mt-2 p-2 bg-info text-white rounded" style="display: none;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-cog me-2"></i>
                    <div>
                        <small><strong>Monitoreo en Segundo Plano</strong></small>
                        <div class="small">Funciona incluso cuando la app está cerrada o el celular bloqueado</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (session('success')): ?>
        <div class="alert alert-success py-2"><?= esc(session('success')) ?></div>
    <?php endif; ?>
    <?php if (session('error')): ?>
        <div class="alert alert-danger py-2"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <!-- Filtros compactos -->
    <div class="card mb-3">
        <div class="card-header py-2">
            <h6 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h6>
        </div>
        <div class="card-body p-3">
            <form method="get" class="row g-2">
                <div class="col-6">
                    <label class="form-label small mb-1">Estado</label>
                    <select name="estado" class="form-select form-select-sm">
                        <option value="">Todos</option>
                        <option value="en_camino" <?= ($estado_filtro == 'en_camino') ? 'selected' : '' ?>>En Camino</option>
                        <option value="entregado" <?= ($estado_filtro == 'entregado') ? 'selected' : '' ?>>Entregado</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label small mb-1">Ordenar</label>
                    <select name="orden" class="form-select form-select-sm">
                        <option value="fecha_desc" <?= ($orden == 'fecha_desc') ? 'selected' : '' ?>>Recientes</option>
                        <option value="fecha_asc" <?= ($orden == 'fecha_asc') ? 'selected' : '' ?>>Antiguos</option>
                        <option value="prioridad" <?= ($orden == 'prioridad') ? 'selected' : '' ?>>Prioridad</option>
                    </select>
                </div>
                <div class="col-12 mt-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-search me-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de pedidos en formato móvil -->
    <div class="pedidos-container">
                <?php foreach ($pedidos as $pedido): ?>
            <div class="card mb-3 pedido-card">
                <div class="card-header py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">
                            <i class="fas fa-shopping-bag me-2 text-primary"></i>
                            Pedido #<?= esc($pedido['id']) ?>
                        </h6>
                        <span class="badge <?= $pedido['estado'] == 'en_camino' ? 'bg-primary' : 'bg-success' ?>">
                            <?= $pedido['estado'] == 'en_camino' ? 'En Camino' : 'Entregado' ?>
                        </span>
                    </div>
                </div>
                
                <div class="card-body p-3">
                    <!-- Información del cliente -->
                    <div class="cliente-info mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-user text-muted me-2"></i>
                                <strong><?= esc($pedido['nombre']) ?></strong>
                        </div>
                                <?php if (!empty($pedido['celular'])): ?>
                            <div class="d-flex align-items-center mb-1">
                                <i class="fas fa-phone text-muted me-2"></i>
                                <small><?= esc($pedido['celular']) ?></small>
                            </div>
                                <?php endif; ?>
                                <?php if (!empty($pedido['correo_electronico'])): ?>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-envelope text-muted me-2"></i>
                                <small><?= esc($pedido['correo_electronico']) ?></small>
                            </div>
                                <?php endif; ?>
                            </div>

                    <!-- Dirección -->
                    <div class="direccion-info mb-3">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-map-marker-alt text-danger me-2 mt-1"></i>
                            <div>
                                <strong>Dirección:</strong>
                                <div class="small"><?= esc($pedido['direccion_entrega']) ?></div>
                                <?php if (!empty($pedido['observaciones'])): ?>
                                    <div class="text-muted small mt-1">
                                        <i class="fas fa-info-circle me-1"></i>
                                        <?= esc(substr($pedido['observaciones'], 0, 100)) ?><?= strlen($pedido['observaciones']) > 100 ? '...' : '' ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            </div>
                            </div>

                    <!-- Información de pago -->
                    <div class="pago-info mb-3">
                        <div class="row">
                            <div class="col-6">
                                <div class="text-center p-2 bg-light rounded">
                                    <div class="small text-muted">Total</div>
                                    <strong class="text-primary">$<?= esc($pedido['total']) ?></strong>
                            </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-2 bg-light rounded">
                                    <div class="small text-muted">Pago</div>
                                    <span class="badge <?= $pedido['estado_pago'] == 'pagado' ? 'bg-success' : 'bg-warning' ?>">
                                        <?= ucfirst($pedido['estado_pago']) ?>
                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <small class="text-muted">
                                <i class="fas fa-credit-card me-1"></i>
                                <?= ucfirst($pedido['metodo_pago']) ?>
                            </small>
                        </div>
                    </div>

                    <!-- Fecha -->
                    <div class="fecha-info mb-3">
                        <div class="text-center">
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                <?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?>
                            </small>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="acciones-buttons">
                        <div class="row g-2">
                            <div class="col-6">
                                <button type="button" class="btn btn-success btn-sm w-100" 
                                            onclick="cambiarEstado(<?= $pedido['id'] ?>, 'entregado')">
                                        <i class="fas fa-check me-1"></i>Entregado
                                    </button>
                            </div>
                            <div class="col-6">
                                <a href="<?= base_url('repartidor/pedidos/' . $pedido['id']) ?>" 
                                   class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-eye me-1"></i>Detalles
                                </a>
                            </div>
                                    <?php if ($pedido['estado_pago'] == 'pendiente' && $pedido['metodo_pago'] == 'efectivo'): ?>
                                <div class="col-12 mt-2">
                                    <button type="button" class="btn btn-warning btn-sm w-100" 
                                                onclick="marcarPagoRecibido(<?= $pedido['id'] ?>)">
                                            <i class="fas fa-money-bill me-1"></i>Cobrado
                                        </button>
                                </div>
                                    <?php endif; ?>
                            <div class="col-6 mt-2">
                                <button type="button" class="btn btn-info btn-sm w-100" 
                                        onclick="verDireccionEnvio(<?= $pedido['id'] ?>, '<?= esc($pedido['direccion_entrega']) ?>')">
                                    <i class="fas fa-map-marker-alt me-1"></i>Maps
                                </button>
                                </div>
                            <div class="col-6 mt-2">
                                <button type="button" class="btn btn-outline-primary btn-sm w-100" 
                                        onclick="mostrarRuta(<?= $pedido['id'] ?>, '<?= esc($pedido['direccion_entrega']) ?>', '<?= esc($pedido['nombre']) ?>')">
                                    <i class="fas fa-route me-1"></i>Ruta
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <?php endforeach; ?>
    </div>

    <?php if (empty($pedidos)): ?>
        <div class="text-center py-5">
            <i class="fas fa-motorcycle fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No hay pedidos asignados</h5>
            <p class="text-muted">No tienes pedidos pendientes de entrega.</p>
        </div>
    <?php endif; ?>
</div>

<style>
/* Estilos específicos para móvil */
@media (max-width: 768px) {
    .container-fluid {
        padding: 0.5rem;
    }
    
    .pedido-card {
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 1rem;
    }
    
    .pedido-card .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #dee2e6;
    }
    
    .cliente-info, .direccion-info, .pago-info {
        border-bottom: 1px solid #f8f9fa;
        padding-bottom: 0.75rem;
    }
    
    .acciones-buttons .btn {
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
    }
    
    /* Mejorar targets táctiles */
    .btn {
        min-height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Animaciones suaves */
    .pedido-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .pedido-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    /* Mejorar legibilidad */
    .small {
        font-size: 0.875rem;
    }
    
    /* Iconos más grandes para móvil */
    .fas {
        font-size: 1.1em;
    }
}

/* Estilos para el mapa en móvil */
#map {
    border: 2px solid #dee2e6;
}

/* Mejorar el contraste de los badges */
.badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.5rem;
}

/* Estilos para los filtros */
.form-select-sm {
    font-size: 0.875rem;
    padding: 0.375rem 0.5rem;
}

/* Mejorar la información de pago */
.pago-info .bg-light {
    background-color: #f8f9fa !important;
    border: 1px solid #e9ecef;
}

/* Animación para los botones de acción */
.acciones-buttons .btn:active {
    transform: scale(0.95);
}

/* Estilos para la información de ruta */
#route-info {
    border-left: 4px solid #4285F4;
    background: linear-gradient(135deg, #f8f9fa 0%, #e3f2fd 100%);
}

#route-info .btn-outline-danger {
    border-color: #dc3545;
    color: #dc3545;
}

#route-info .btn-outline-danger:hover {
    background-color: #dc3545;
    color: white;
}

/* Mejorar contraste de botones de ruta */
.btn-outline-primary {
    border-color: #4285F4;
    color: #4285F4;
}

.btn-outline-primary:hover {
    background-color: #4285F4;
    color: white;
}

/* Estilos para el mapa con rutas */
#map {
    border: 2px solid #dee2e6;
    position: relative;
}

/* Indicador de ruta activa */
.route-active {
    border: 2px solid #4285F4 !important;
    box-shadow: 0 0 10px rgba(66, 133, 244, 0.3);
}

/* Animación para botones de ruta */
.btn[onclick*="mostrarRuta"] {
    transition: all 0.2s ease;
}

.btn[onclick*="mostrarRuta"]:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Mejorar legibilidad en móvil */
@media (max-width: 768px) {
    #route-info {
        font-size: 0.875rem;
        padding: 0.75rem;
    }
    
    #route-details {
        line-height: 1.4;
    }
    
    .btn-group-sm .btn {
        padding: 0.375rem 0.5rem;
        font-size: 0.75rem;
    }
}
</style>

<script>
let ultimaUbicacion = null;
let watchId = null;
let pedidosActivos = [];
let monitoreoActivo = false;
let map;
let markers = [];
let miUbicacionMarker = null;
let directionsService;
let directionsRenderer;
let rutaActiva = null;

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
        fetch('<?= base_url('repartidor/actualizar-ubicacion') ?>', {
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
            
                    fetch('<?= base_url('repartidor/actualizar-ubicacion') ?>', {
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
    console.log('Intentando marcar pago como recibido para pedido:', pedidoId);
    
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
        .then(response => {
            console.log('Respuesta del servidor:', response.status, response.statusText);
            return response.json();
        })
        .then(data => {
            console.log('Datos de respuesta:', data);
            if (data.success) {
                showToast('Pago marcado como recibido para el pedido #' + pedidoId, 'success');
                // Recargar la página después de un breve delay
                setTimeout(() => {
                location.reload();
                }, 1500);
            } else {
                showToast('Error: ' + (data.message || 'Error desconocido'), 'error');
                if (data.debug) {
                    console.log('Debug info:', data.debug);
                }
            }
        })
        .catch(error => {
            console.error('Error en la petición:', error);
            showToast('Error al marcar el pago como recibido: ' + error.message, 'error');
        });
    }
}

// Funciones de ruta
function mostrarRuta(pedidoId, direccion, nombreCliente) {
    if (!direccion || direccion.trim() === '') {
        showToast('No hay dirección disponible para mostrar la ruta', 'error');
        return;
    }

    // Obtener ubicación actual del repartidor
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const origen = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            
            // Calcular ruta
            calcularRuta(origen, direccion, pedidoId, nombreCliente);
        }, function(error) {
            showToast('Error al obtener tu ubicación: ' + error.message, 'error');
        }, {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 30000
        });
    } else {
        showToast('Geolocalización no disponible', 'error');
    }
}

function calcularRuta(origen, destino, pedidoId, nombreCliente) {
    if (!directionsService || !directionsRenderer) {
        showToast('Servicio de rutas no disponible', 'error');
        return;
    }

    const request = {
        origin: origen,
        destination: destino,
        travelMode: google.maps.TravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.METRIC
    };

    directionsService.route(request, function(result, status) {
        if (status === 'OK') {
            // Limpiar ruta anterior si existe
            if (rutaActiva) {
                directionsRenderer.setDirections({routes: []});
            }
            
            // Mostrar nueva ruta
            directionsRenderer.setDirections(result);
            rutaActiva = {
                pedidoId: pedidoId,
                nombreCliente: nombreCliente,
                direccion: destino,
                distancia: result.routes[0].legs[0].distance.text,
                duracion: result.routes[0].legs[0].duration.text
            };
            
            // Mostrar información de la ruta
            mostrarInformacionRuta();
            
            // Centrar mapa en la ruta
            const bounds = new google.maps.LatLngBounds();
            bounds.extend(origen);
            bounds.extend(result.routes[0].bounds.getNorthEast());
            bounds.extend(result.routes[0].bounds.getSouthWest());
            map.fitBounds(bounds);
            
            showToast(`Ruta calculada: ${rutaActiva.distancia} - ${rutaActiva.duracion}`, 'success');
        } else {
            showToast('Error al calcular la ruta: ' + status, 'error');
        }
    });
}

function mostrarInformacionRuta() {
    if (!rutaActiva) return;
    
    const routeInfo = document.getElementById('route-info');
    const routeDetails = document.getElementById('route-details');
    
    routeDetails.innerHTML = `
        <strong>Pedido #${rutaActiva.pedidoId}</strong> - ${rutaActiva.nombreCliente}<br>
        <small class="text-muted">
            <i class="fas fa-road me-1"></i>${rutaActiva.distancia} 
            <i class="fas fa-clock me-1 ms-2"></i>${rutaActiva.duracion}
        </small>
    `;
    
    routeInfo.style.display = 'block';
}

function limpiarRutas() {
    if (directionsRenderer) {
        directionsRenderer.setDirections({routes: []});
    }
    
    rutaActiva = null;
    document.getElementById('route-info').style.display = 'none';
    
    // Volver a centrar en los marcadores de pedidos
    if (markers.length > 0) {
        const bounds = new google.maps.LatLngBounds();
        markers.forEach(marker => {
            bounds.extend(marker.getPosition());
        });
        map.fitBounds(bounds);
    }
    
    showToast('Rutas limpiadas', 'info');
}

// Google Maps Functions
function initMap() {
    console.log('Inicializando mapa...');
    
    // Verificar que Google Maps esté completamente cargado
    if (typeof google === 'undefined' || !google.maps || !google.maps.Map) {
        console.error('Google Maps API no está disponible');
        mostrarErrorMapa('Google Maps API no está disponible. Recarga la página.');
        return;
    }
    
    try {
        // Centrar en Clorinda, Formosa
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: -25.291388888889, lng: -57.718333333333 },
            zoom: 13,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: true
        });
        
        // Inicializar servicios de direcciones
        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer({
            suppressMarkers: true, // No mostrar marcadores automáticos
            polylineOptions: {
                strokeColor: '#4285F4',
                strokeWeight: 4,
                strokeOpacity: 0.8
            }
        });
        directionsRenderer.setMap(map);
        
        console.log('Mapa inicializado correctamente');
        
        // Cargar pedidos en el mapa
        cargarPedidosEnMapa();
    } catch (error) {
        console.error('Error al inicializar el mapa:', error);
        mostrarErrorMapa('Error al inicializar el mapa: ' + error.message);
    }
}

function cargarPedidosEnMapa() {
    console.log('Cargando pedidos en el mapa...');
    const pedidos = <?= json_encode($pedidos) ?>;
    console.log('Pedidos disponibles:', pedidos.length);
    
    let marcadoresAgregados = 0;
    pedidos.forEach((pedido, index) => {
        if (pedido.latitud && pedido.longitud) {
            console.log(`Agregando marcador para pedido #${pedido.id} en ${pedido.latitud}, ${pedido.longitud}`);
            
            // Usar marcador moderno si está disponible, sino usar el clásico
            let marker;
            if (google.maps.marker && google.maps.marker.AdvancedMarkerElement) {
                // Marcador moderno
                const pinElement = document.createElement('div');
                pinElement.innerHTML = `
                    <div style="
                        background-color: ${pedido.estado === 'en_camino' ? '#4285F4' : '#34A853'};
                        border: 2px solid white;
                        border-radius: 50%;
                        width: 24px;
                        height: 24px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: white;
                        font-weight: bold;
                        font-size: 12px;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.3);
                    ">
                        ${pedido.id}
                    </div>
                `;
                
                marker = new google.maps.marker.AdvancedMarkerElement({
                    position: { lat: parseFloat(pedido.latitud), lng: parseFloat(pedido.longitud) },
                    map: map,
                    title: `Pedido #${pedido.id} - ${pedido.nombre}`,
                    content: pinElement
                });
            } else {
                // Marcador clásico (fallback)
                marker = new google.maps.Marker({
                    position: { lat: parseFloat(pedido.latitud), lng: parseFloat(pedido.longitud) },
                    map: map,
                    title: `Pedido #${pedido.id} - ${pedido.nombre}`,
                    icon: {
                        url: pedido.estado === 'en_camino' 
                            ? 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png'
                            : 'https://maps.google.com/mapfiles/ms/icons/green-dot.png',
                        scaledSize: new google.maps.Size(32, 32)
                    }
                });
            }
            
            // Info window con detalles del pedido
            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div style="min-width: 200px;">
                        <h6><strong>Pedido #${pedido.id}</strong></h6>
                        <p><strong>Cliente:</strong> ${pedido.nombre}</p>
                        <p><strong>Dirección:</strong> ${pedido.direccion_entrega}</p>
                        <p><strong>Estado:</strong> ${pedido.estado}</p>
                        <p><strong>Total:</strong> $${pedido.total}</p>
                        <div class="d-flex gap-1 mt-2">
                            <button onclick="verPedidoDetalle(${pedido.id})" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>Detalles
                            </button>
                            <button onclick="mostrarRuta(${pedido.id}, '${pedido.direccion_entrega}', '${pedido.nombre}')" class="btn btn-info btn-sm">
                                <i class="fas fa-route me-1"></i>Ruta
                            </button>
                        </div>
                    </div>
                `
            });
            
            // Agregar evento click
            if (google.maps.marker && google.maps.marker.AdvancedMarkerElement) {
                marker.addListener('click', function() {
                    infoWindow.open(map, marker);
                });
            } else {
                marker.addListener('click', function() {
                    infoWindow.open(map, marker);
                });
            }
            
            markers.push(marker);
            marcadoresAgregados++;
        } else {
            console.log(`Pedido #${pedido.id} sin coordenadas:`, pedido);
        }
    });
    
    console.log(`Total de marcadores agregados: ${marcadoresAgregados}`);
}

function mostrarErrorMapa(mensaje) {
    const errorDiv = document.getElementById('map-error');
    const errorMessage = document.getElementById('error-message');
    if (errorDiv && errorMessage) {
        errorMessage.textContent = mensaje;
        errorDiv.style.display = 'block';
    }
    console.error('Error del mapa:', mensaje);
}

function enviarUbicacionAlServidor(lat, lng) {
    // Solo enviar si hay un pedido activo
    const pedidosEnCamino = <?= json_encode(array_filter($pedidos, function($p) { return $p['estado'] == 'en_camino'; })) ?>;
    
    if (pedidosEnCamino.length === 0) {
        console.log('No hay pedidos en camino, no se envía ubicación');
        return;
    }
    
    const pedidoActivo = pedidosEnCamino[0];
    
    fetch('<?= base_url('repartidor/actualizar-ubicacion') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            pedido_id: pedidoActivo.id,
            latitud: lat,
            longitud: lng
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            console.log('Ubicación enviada al servidor');
        } else {
            console.warn('Error al enviar ubicación:', data.message);
        }
    })
    .catch(error => {
        console.error('Error al enviar ubicación:', error);
        // No mostrar error al usuario para evitar spam
    });
}

function verPedidoDetalle(pedidoId) {
    window.location.href = `<?= base_url('repartidor/pedidos/') ?>${pedidoId}`;
}

function showToast(message, type) {
    const toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) {
        const container = document.createElement('div');
        container.id = 'toastContainer';
        container.style.position = 'fixed';
        container.style.top = '20px';
        container.style.right = '20px';
        container.style.zIndex = '1100';
        document.body.appendChild(container);
    }
    
    const toast = document.createElement('div');
    toast.className = `toast show align-items-center text-white bg-${type} border-0`;
    toast.role = 'alert';
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    toast.style.marginBottom = '10px';
    
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;
    
    document.getElementById('toastContainer').appendChild(toast);
    
    setTimeout(() => {
        toast.classList.remove('show');
        toast.classList.add('hide');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 5000);
}

// Inicialización cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    // Registrar Service Worker para monitoreo en segundo plano
    registrarServiceWorker();
    
    // Obtener pedidos activos (en_camino)
    const pedidosEnCamino = <?= json_encode(array_filter($pedidos, function($p) { return $p['estado'] == 'en_camino'; })) ?>;
    
    // Función para inicializar mapa cuando Google Maps esté listo
    function initializeMapWhenReady() {
        if (typeof google !== 'undefined' && google.maps && google.maps.Map) {
            console.log('Google Maps API cargada, inicializando mapa...');
            initMap();
            
            // Iniciar monitoreo automáticamente si hay pedidos en camino
    if (pedidosEnCamino.length > 0) {
                setTimeout(() => {
                    iniciarMonitoreoUbicacion(pedidosEnCamino[0].id);
                    document.getElementById('btn-monitoreo').innerHTML = '<i class="fas fa-satellite-dish text-success"></i>';
                    document.getElementById('btn-monitoreo').title = 'Desactivar monitoreo';
                    document.getElementById('monitoreo-status').style.display = 'block';
                    showToast('Monitoreo automático activado - Los clientes pueden seguirte en tiempo real', 'success');
                }, 2000); // Esperar 2 segundos para que el mapa se cargue completamente
            }
        } else {
            console.log('Google Maps API aún no está disponible, esperando...');
            setTimeout(initializeMapWhenReady, 100);
        }
    }
    
    // Iniciar el proceso de inicialización
    initializeMapWhenReady();
    
    // También escuchar el evento de carga de la ventana como respaldo
    window.addEventListener('load', function() {
        if (typeof google !== 'undefined' && google.maps && google.maps.Map && !map) {
            console.log('Inicializando mapa desde evento load...');
            initMap();
        }
    });
});

// Función para registrar Service Worker (DESHABILITADA)
async function registrarServiceWorker() {
    console.log('Service Worker deshabilitado, usando solo Web Worker');
    document.getElementById('sw-status').style.display = 'none';
    inicializarWebWorker();
}

// Función para inicializar Web Worker
function inicializarWebWorker() {
    if (typeof Worker !== 'undefined') {
        try {
            locationWorker = new Worker('<?= base_url('worker-location.js') ?>');
            
            // Escuchar mensajes del Web Worker
            locationWorker.addEventListener('message', function(event) {
                console.log('Mensaje del Web Worker:', event.data);
                
                switch(event.data.type) {
                    case 'LOCATION_UPDATE':
                        actualizarMarcadorUbicacion(event.data.lat, event.data.lng);
                        break;
                    case 'SERVER_UPDATE':
                        console.log('Ubicación enviada al servidor:', event.data.success);
                        if (event.data.success) {
                            showToast('Ubicación actualizada', 'success');
                        } else {
                            showToast('Error al enviar ubicación', 'error');
                        }
                        break;
                    case 'LOCATION_ERROR':
                        console.error('Error de ubicación:', event.data.error);
                        showToast('Error de ubicación: ' + event.data.error, 'error');
                        break;
                    case 'MONITORING_STARTED':
                        console.log('Monitoreo iniciado en Web Worker');
                        showToast('Monitoreo iniciado (Web Worker)', 'success');
                        break;
                    case 'MONITORING_STOPPED':
                        console.log('Monitoreo detenido en Web Worker');
                        showToast('Monitoreo detenido', 'warning');
                        break;
                    case 'STATUS':
                        console.log('Estado del Web Worker:', event.data);
                        break;
                }
            });
            
            console.log('Web Worker inicializado correctamente');
            
        } catch (error) {
            console.error('Error al inicializar Web Worker:', error);
            showToast('Error al inicializar Web Worker', 'error');
        }
    } else {
        console.log('Web Worker no soportado, usando monitoreo local');
        showToast('Web Worker no soportado, usando monitoreo local', 'warning');
    }
}

// Función para enviar mensaje al Service Worker (DESHABILITADA)
function enviarMensajeSW(tipo, datos) {
    console.log('Service Worker deshabilitado, usando Web Worker');
    return false;
}

// Función para enviar mensaje al Web Worker
function enviarMensajeWW(tipo, datos) {
    if (locationWorker) {
        try {
            locationWorker.postMessage({
                type: tipo,
                ...datos
            });
            return true;
        } catch (error) {
            console.error('Error al enviar mensaje al Web Worker:', error);
            return false;
        }
    }
    return false;
}

// Función para iniciar monitoreo de ubicación
function iniciarMonitoreoUbicacion(pedidoId) {
    console.log('Iniciando monitoreo de ubicación para pedido:', pedidoId);
    
    // Usar solo Web Worker
    const wwActivo = enviarMensajeWW('START_MONITORING', { pedidoId: pedidoId });
    
    if (wwActivo) {
        console.log('Monitoreo iniciado con Web Worker');
        showToast('Monitoreo iniciado (Web Worker)', 'success');
    } else {
        console.log('Web Worker no disponible, usando monitoreo local');
        showToast('Monitoreo iniciado (modo local)', 'info');
        
        // Monitoreo local como respaldo
        if (watchId) {
            navigator.geolocation.clearWatch(watchId);
        }
        
        monitoreoActivo = true;
        
        // Solicitar ubicación inicial
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                // Actualizar marcador de ubicación actual
                actualizarMarcadorUbicacion(lat, lng);
                
                // Enviar ubicación inicial al servidor
                enviarUbicacionAlServidor(lat, lng);
                
                showToast('Monitoreo de ubicación iniciado', 'success');
            }, function(error) {
                let mensajeError = 'Error al obtener ubicación inicial';
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        mensajeError = 'Permiso de ubicación denegado. Por favor, habilita la ubicación en tu navegador.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        mensajeError = 'Ubicación no disponible. Verifica tu conexión GPS.';
                        break;
                    case error.TIMEOUT:
                        mensajeError = 'Timeout al obtener ubicación. Intenta de nuevo.';
                        break;
                    default:
                        mensajeError = error.message || 'Error desconocido';
                }
                showToast(mensajeError, 'error');
            }, {
                enableHighAccuracy: true,
                timeout: 30000,
                maximumAge: 60000
            });
        }
        
        // Iniciar monitoreo continuo local como respaldo
        watchId = navigator.geolocation.watchPosition(
            function(position) {
                const nuevaLat = position.coords.latitude;
                const nuevaLon = position.coords.longitude;
                
                if (esCambioSignificativo(nuevaLat, nuevaLon)) {
                    actualizarMarcadorUbicacion(nuevaLat, nuevaLon);
                    enviarUbicacionAlServidor(nuevaLat, nuevaLon);
                }
            },
            function(error) {
                console.error('Error en monitoreo de ubicación:', error);
                let mensajeError = 'Error en monitoreo de ubicación';
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        mensajeError = 'Permiso de ubicación denegado';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        mensajeError = 'Ubicación no disponible';
                        break;
                    case error.TIMEOUT:
                        mensajeError = 'Timeout en monitoreo';
                        break;
                    default:
                        mensajeError = error.message || 'Error desconocido';
                }
                console.error(mensajeError);
            },
            {
                enableHighAccuracy: true,
                timeout: 30000,
                maximumAge: 60000
            }
        );
    }
}

// Función para detener monitoreo
function detenerMonitoreoUbicacion() {
    console.log('Deteniendo monitoreo de ubicación');
    
    // Enviar mensaje al Web Worker para detener monitoreo
    enviarMensajeWW('STOP_MONITORING');
    
    if (watchId) {
        navigator.geolocation.clearWatch(watchId);
        watchId = null;
    }
    
    monitoreoActivo = false;
    
    showToast('Monitoreo detenido', 'warning');
}

// Función para actualizar marcador de ubicación
function actualizarMarcadorUbicacion(lat, lng) {
    if (!map) return;
    
    // Actualizar marcador de mi ubicación
    if (miUbicacionMarker) {
        if (google.maps.marker && google.maps.marker.AdvancedMarkerElement) {
            miUbicacionMarker.map = null;
        } else {
            miUbicacionMarker.setMap(null);
        }
    }
    
    // Crear ícono de Material Symbols moped para ubicación actual
    const motoIconActual = {
        url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
            <svg width="32" height="32" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 7c0-1.1-.9-2-2-2h-3v2h3v2.65L13.52 14H10V9H6c-2.21 0-4 1.79-4 4v3h2c0 1.66 1.34 3 3 3s3-1.34 3-3h4.48L19 10.35V7zM7 17c-.55 0-1-.45-1-1h2c0 .55-.45 1-1 1z" fill="#FF1744"/>
                <path d="M5 6h5v2H5z" fill="#FF1744"/>
                <path d="M19 13c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zm0 4c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z" fill="#FF1744"/>
            </svg>
        `),
        scaledSize: new google.maps.Size(32, 32),
        anchor: new google.maps.Point(16, 16)
    };
    
    // Crear marcador de ubicación actual
    if (google.maps.marker && google.maps.marker.AdvancedMarkerElement) {
        const pinElement = document.createElement('div');
        pinElement.innerHTML = `
            <div style="
                color: #FF1744;
                font-size: 28px;
                text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
                filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.3));
            ">
                <span class="material-symbols-outlined" style="font-size: inherit;">moped</span>
            </div>
        `;
        
        miUbicacionMarker = new google.maps.marker.AdvancedMarkerElement({
            position: { lat: lat, lng: lng },
            map: map,
            title: 'Mi ubicación actual',
            content: pinElement
        });
    } else {
        miUbicacionMarker = new google.maps.Marker({
            position: { lat: lat, lng: lng },
            map: map,
            title: 'Mi ubicación actual',
            icon: motoIconActual
        });
    }
    
    // Centrar mapa en mi ubicación si es la primera vez
    if (!ultimaUbicacion) {
        map.setCenter({ lat: lat, lng: lng });
        map.setZoom(15);
    }
    
    ultimaUbicacion = { latitud: lat, longitud: lng };
}

function toggleMonitoreo() {
    const pedidosEnCamino = <?= json_encode(array_filter($pedidos, function($p) { return $p['estado'] == 'en_camino'; })) ?>;
    
    if (monitoreoActivo) {
        detenerMonitoreoUbicacion();
        document.getElementById('btn-monitoreo').innerHTML = '<i class="fas fa-satellite-dish"></i>';
        document.getElementById('btn-monitoreo').title = 'Activar monitoreo';
        document.getElementById('monitoreo-status').style.display = 'none';
        showToast('Monitoreo desactivado', 'warning');
    } else {
        if (pedidosEnCamino.length === 0) {
            showToast('No hay pedidos en camino para monitorear', 'info');
            return;
        }
        
        iniciarMonitoreoUbicacion(pedidosEnCamino[0].id);
        document.getElementById('btn-monitoreo').innerHTML = '<i class="fas fa-satellite-dish text-success"></i>';
        document.getElementById('btn-monitoreo').title = 'Desactivar monitoreo';
        document.getElementById('monitoreo-status').style.display = 'block';
        showToast('Monitoreo activado - Los clientes pueden seguirte en tiempo real', 'success');
    }
}

// Manejar errores de Google Maps
window.addEventListener('error', function(e) {
    if (e.filename && e.filename.includes('maps.googleapis.com')) {
        console.error('Error en Google Maps API:', e.message);
        mostrarErrorMapa('Error al cargar Google Maps. Verifica tu conexión a internet.');
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

<!-- Google Maps Script -->
<?= google_maps_script('places,geometry') ?> 