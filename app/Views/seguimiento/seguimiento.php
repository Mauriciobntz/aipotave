<div class="container-fluid mt-5 pt-5 mb-5">
<style>
/* Fondo claro para vista pública */
body {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 50%, #f8f9fa 100%);
    min-height: 100vh;
}

.container-fluid {
    background: transparent;
}
</style>
    <!-- Header del seguimiento -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-3 seguimiento-card">
                <div class="card-header seguimiento-header">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <div class="mb-2 mb-md-0">
                            <h5 class="mb-0 seguimiento-title">
                                <i class="fas fa-motorcycle me-2"></i>Seguimiento en Tiempo Real
                            </h5>
                            <small class="seguimiento-subtitle">Pedido #<?= esc($pedido['codigo_seguimiento']) ?></small>
                        </div>
                        <div class="text-start text-md-end">
                            <div class="badge seguimiento-badge <?= $pedido['estado'] == 'en_camino' ? 'badge-en-camino' : 'badge-default' ?> fs-6">
                                <?php if ($pedido['estado'] == 'en_camino'): ?>
                                    <i class="fas fa-motorcycle me-1"></i>
                                <?php endif; ?>
                                <?= ucfirst($pedido['estado']) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                            <h6 class="seguimiento-section-title"><i class="fas fa-info-circle me-2"></i>Información del Pedido</h6>
                            <ul class="list-unstyled seguimiento-info-list">
                                <li class="seguimiento-info-item"><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?></li>
                                <li class="seguimiento-info-item"><strong>Total:</strong> $<?= esc($pedido['total']) ?></li>
                                <li class="seguimiento-info-item"><strong>Dirección:</strong> <?= esc($pedido['direccion_entrega']) ?></li>
                                <?php if (!empty($pedido['repartidor_nombre'])): ?>
                                    <li class="seguimiento-info-item"><strong>Repartidor:</strong> <?= esc($pedido['repartidor_nombre']) ?></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Indicador de estado permanente -->
    <?php if ($pedido['estado'] == 'en_camino'): ?>
    <div class="row mb-3">
        <div class="col-12">
            <div class="card border-0 seguimiento-en-camino-card">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <div class="d-flex align-items-center mb-3 mb-md-0">
                            <div class="me-3">
                                <i class="fas fa-motorcycle fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold">🚚 En Camino</h5>
                                <p class="mb-0">El repartidor se dirige hacia tu dirección</p>
                            </div>
                        </div>
                        <div class="text-center text-md-end">
                            <div class="seguimiento-timer">
                                <small class="text-muted">Tiempo estimado</small>
                                <div class="fw-bold">15-20 min</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php elseif ($pedido['estado'] == 'pendiente'): ?>
    <div class="row mb-3">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #ffc107, #ffb74d); color: white; border-radius: 12px;">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <div class="d-flex align-items-center mb-3 mb-md-0">
                            <div class="me-3">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold">⏳ Pendiente</h5>
                                <p class="mb-0">Por favor confirma tu pedido para continuar.</p>
                            </div>
                        </div>
                        <div class="text-center text-md-end">
                            <div class="badge bg-white text-warning fs-6">
                                <i class="fas fa-clock me-1"></i>Pendiente
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php elseif ($pedido['estado'] == 'confirmado'): ?>
    <div class="row mb-3">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #17a2b8, #20c997); color: white; border-radius: 12px;">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <div class="d-flex align-items-center mb-3 mb-md-0">
                            <div class="me-3">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold">✅ Confirmado</h5>
                                <p class="mb-0">Tu pedido ha sido confirmado y está en preparación</p>
                            </div>
                        </div>
                        <div class="text-center text-md-end">
                            <div class="badge bg-white text-info fs-6">
                                <i class="fas fa-check-circle me-1"></i>Confirmado
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php elseif ($pedido['estado'] == 'en_preparacion'): ?>
    <div class="row mb-3">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #fd7e14, #ff8c42); color: white; border-radius: 12px;">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <div class="d-flex align-items-center mb-3 mb-md-0">
                            <div class="me-3">
                                <i class="fas fa-utensils fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold">👨‍🍳 En Preparación</h5>
                                <p class="mb-0">Tu pedido está siendo preparado en la cocina</p>
                            </div>
                        </div>
                        <div class="text-center text-md-end">
                            <div class="badge bg-white text-warning fs-6">
                                <i class="fas fa-utensils me-1"></i>En Preparación
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php elseif ($pedido['estado'] == 'entregado'): ?>
    <div class="row mb-3">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #6f42c1, #8e44ad); color: white; border-radius: 12px;">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <div class="d-flex align-items-center mb-3 mb-md-0">
                            <div class="me-3">
                                <i class="fas fa-check-double fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold">🎉 Entregado</h5>
                                <p class="mb-0">Tu pedido ha sido entregado exitosamente</p>
                            </div>
                        </div>
                        <div class="text-center text-md-end">
                            <div class="badge bg-white text-success fs-6">
                                <i class="fas fa-check-double me-1"></i>Entregado
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php elseif ($pedido['estado'] == 'cancelado'): ?>
    <div class="row mb-3">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #dc3545, #c82333); color: white; border-radius: 12px;">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <div class="d-flex align-items-center mb-3 mb-md-0">
                            <div class="me-3">
                                <i class="fas fa-times-circle fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold">❌ Cancelado</h5>
                                <p class="mb-0">Tu pedido ha sido cancelado. Contacta a soporte al cliente.</p>
                            </div>
                        </div>
                        <div class="text-center text-md-end">
                            <div class="badge bg-white text-danger fs-6">
                                <i class="fas fa-times-circle me-1"></i>Cancelado
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

<?php 
// Obtener configuración del mapa de seguimiento
$configuracionModel = new \App\Models\ConfiguracionModel();
$mapaConfig = $configuracionModel->getConfiguracionMapaSeguimiento();
$mapaActivo = $mapaConfig['activo'];
?>

<?php if ($pedido['estado'] == 'en_camino' && $mapaActivo): ?>
    <!-- Mapa de seguimiento -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <h6 class="mb-2 mb-md-0">
                            <i class="fas fa-map-marked-alt me-2"></i>Ubicación del Repartidor
                        </h6>
                        <?php if ($mapaConfig['mostrar_ruta']): ?>
                        <div class="btn-group btn-group-sm">
                            <button onclick="toggleRuta()" class="btn btn-outline-primary btn-sm" id="btn-ruta" title="Mostrar/Ocultar ruta">
                                <i class="fas fa-route"></i>
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="map" style="height: 300px; width: 100%;"></div>
                    <div id="map-error" class="alert alert-warning m-3" style="display: none;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Error del mapa:</strong> <span id="error-message"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información de tiempo estimado -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4 text-center">
                            <div class="border-end">
                                <h6 class="text-muted">Tiempo Estimado</h6>
                                <h4 id="tiempo-estimado" class="text-primary">--</h4>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="border-end">
                                <h6 class="text-muted">Distancia</h6>
                                <h4 id="distancia" class="text-info">--</h4>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <h6 class="text-muted">Última Actualización</h6>
                            <h4 id="ultima-actualizacion" class="text-success">--</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php elseif ($pedido['estado'] == 'en_camino' && !$mapaActivo): ?>
    <!-- Mensaje cuando el mapa está desactivado -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-map-marked-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Mapa de Seguimiento Desactivado</h5>
                    <p class="text-muted mb-0">
                        El mapa de seguimiento en tiempo real está temporalmente desactivado por el administrador.
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($pedido['estado'] == 'pendiente' && isset($whatsapp)): ?>
<?php
$productosMsg = '';
if (!empty($detalles)) {
    foreach ($detalles as $item) {
        $nombre = $item['producto_nombre'] ?? $item['combo_nombre'] ?? 'Producto';
        $productosMsg .= $nombre . ' x' . $item['cantidad'] . ' → $' . number_format($item['precio_unitario'] * $item['cantidad'], 2) . "\n";
    }
}
$totalMsg = isset($pedido['total']) ? '$' . number_format($pedido['total'], 2) : '';
$direccionMsg = $pedido['direccion_entrega'] ?? '';
$metodoPagoMsg = ucfirst($pedido['metodo_pago'] ?? '');
$obsMsg = $pedido['observaciones'] ?? '';
$mensajeWA =
    "Confirmación de Pedido #{$pedido['codigo_seguimiento']}\n\n" .
    "Detalle del pedido:\n" . $productosMsg . "\n" .
    "Total: {$totalMsg}\n" .
    "Entrega en: {$direccionMsg}\n" .
    "Pago: {$metodoPagoMsg}";
if ($obsMsg) {
    $mensajeWA .= "\nObservaciones: {$obsMsg}";
}
$mensajeWA .= "\n\nSeguimiento: " . base_url("seguimiento/{$pedido['codigo_seguimiento']}");
?>
<div class="my-4 animate__animated animate__fadeInUp text-center">
    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $whatsapp) ?>?text=<?= urlencode($mensajeWA) ?>"
       target="_blank"
       class="btn btn-success btn-lg btn-hover-effect w-100 w-md-auto mx-auto d-block"
       style="max-width: 420px;">
        <i class="fab fa-whatsapp me-2"></i>Confirmar por WhatsApp
    </a>
    <div class="text-muted mt-2 small">Presiona el botón para confirmar tu pedido y recibir asistencia personalizada.</div>
</div>
<?php endif; ?>

<script>
let map;
let repartidorMarker;
let pedidoId = <?= $pedido['id'] ?>;
let ultimaUbicacion = null;
let intervaloActualizacion;
let directionsService;
let directionsRenderer;
let rutaActiva = null;

// Inicializar mapa
function initMap() {
    console.log('Inicializando mapa de seguimiento...');
    
    // Verificar que el elemento del mapa existe
    const mapElement = document.getElementById('map');
    if (!mapElement) {
        console.error('Elemento del mapa no encontrado');
        return;
    }
    
    if (typeof google === 'undefined' || !google.maps || !google.maps.Map) {
        mostrarErrorMapa('Google Maps API no está disponible');
        return;
    }
    
    try {
        // Centrar en la dirección de entrega
        const direccionEntrega = '<?= esc($pedido['direccion_entrega']) ?>';
        
        // Geocodificar la dirección para centrar el mapa
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ address: direccionEntrega }, function(results, status) {
            let center;
            
            if (status === 'OK' && results[0]) {
                center = results[0].geometry.location;
            } else {
                // Fallback a Clorinda, Formosa
                center = { lat: -25.291388888889, lng: -57.718333333333 };
            }
            
            // Crear el mapa solo si no existe
            if (!map) {
                // Usar configuración del zoom por defecto
                const zoomDefault = <?= $mapaConfig['zoom_default'] ?? 15 ?>;
                
                map = new google.maps.Map(mapElement, {
                    center: center,
                    zoom: zoomDefault,
                    mapTypeControl: false,
                    streetViewControl: false,
                    fullscreenControl: true
                });
                
                // Inicializar servicios de direcciones solo si están disponibles y configurados
                if (google.maps.DirectionsService && google.maps.DirectionsRenderer && <?= $mapaConfig['mostrar_ruta'] ? 'true' : 'false' ?>) {
                    directionsService = new google.maps.DirectionsService();
                    directionsRenderer = new google.maps.DirectionsRenderer({
                        suppressMarkers: true,
                        polylineOptions: {
                            strokeColor: '#FF6B35',
                            strokeWeight: 4,
                            strokeOpacity: 0.8
                        }
                    });
                    directionsRenderer.setMap(map);
                }
                
                // Agregar marcador de destino (dirección de entrega)
                new google.maps.Marker({
                    position: center,
                    map: map,
                    title: 'Dirección de entrega',
                    icon: {
                        url: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png',
                        scaledSize: new google.maps.Size(32, 32)
                    }
                });
            }
            
            // Iniciar actualización de ubicación del repartidor
            if ('<?= $pedido['estado'] ?>' === 'en_camino') {
                iniciarActualizacionUbicacion();
            }
        });
        
    } catch (error) {
        console.error('Error al inicializar el mapa:', error);
        mostrarErrorMapa('Error al inicializar el mapa: ' + error.message);
    }
}

// Función para actualizar ubicación del repartidor
function actualizarUbicacionRepartidor() {
    fetch(`<?= base_url('api/seguimiento/ubicacion/') ?>${pedidoId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success && data.data) {
                const ubicacion = data.data;
                
                // Actualizar marcador del repartidor
                if (repartidorMarker) {
                    repartidorMarker.setMap(null);
                }
                
                // Crear ícono de Material Symbols moped con paquete
                const motoIcon = {
                    url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                        <svg width="32" height="32" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 7c0-1.1-.9-2-2-2h-3v2h3v2.65L13.52 14H10V9H6c-2.21 0-4 1.79-4 4v3h2c0 1.66 1.34 3 3 3s3-1.34 3-3h4.48L19 10.35V7zM7 17c-.55 0-1-.45-1-1h2c0 .55-.45 1-1 1z" fill="#FF6B35"/>
                            <path d="M5 6h5v2H5z" fill="#FF6B35"/>
                            <path d="M19 13c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zm0 4c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z" fill="#FF6B35"/>
                            <rect x="16" y="8" width="4" height="4" fill="#FF6B35" rx="1"/>
                        </svg>
                    `),
                    scaledSize: new google.maps.Size(32, 32),
                    anchor: new google.maps.Point(16, 16)
                };
                
                repartidorMarker = new google.maps.Marker({
                    position: { 
                        lat: parseFloat(ubicacion.latitud), 
                        lng: parseFloat(ubicacion.longitud) 
                    },
                    map: map,
                    title: `Repartidor: ${ubicacion.repartidor_nombre}`,
                    icon: motoIcon
                });
                
                // Calcular y mostrar ruta si está disponible
                if (directionsService && directionsRenderer) {
                    calcularRutaRepartidor(ubicacion.latitud, ubicacion.longitud);
                }
                
                // Centrar mapa en el repartidor
                map.setCenter({ 
                    lat: parseFloat(ubicacion.latitud), 
                    lng: parseFloat(ubicacion.longitud) 
                });
                
                // Actualizar información de tiempo y distancia
                actualizarInformacionTiempo(ubicacion);
                
                ultimaUbicacion = ubicacion;
                
                // Ocultar mensaje de error si existe
                const errorDiv = document.getElementById('map-error');
                if (errorDiv) {
                    errorDiv.style.display = 'none';
                }
            } else {
                // No hay ubicación disponible
                mostrarMensajeSinUbicacion(data.message || 'No hay ubicación disponible del repartidor');
            }
        })
        .catch(error => {
            console.error('Error al obtener ubicación del repartidor:', error);
            mostrarMensajeSinUbicacion('Error al obtener la ubicación del repartidor. Inténtalo de nuevo en unos momentos.');
        });
}

// Función para calcular la ruta del repartidor
function calcularRutaRepartidor(latRepartidor, lngRepartidor) {
    // Verificar que los servicios de direcciones estén disponibles
    if (!directionsService || !directionsRenderer) {
        console.log('Servicios de direcciones no disponibles');
        return;
    }
    
    const direccionEntrega = '<?= esc($pedido['direccion_entrega']) ?>';
    
    // Geocodificar la dirección de entrega
    const geocoder = new google.maps.Geocoder();
    geocoder.geocode({ address: direccionEntrega }, function(results, status) {
        if (status === 'OK' && results[0]) {
            const destino = results[0].geometry.location;
            
            const request = {
                origin: { lat: parseFloat(latRepartidor), lng: parseFloat(lngRepartidor) },
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
                        distancia: result.routes[0].legs[0].distance.text,
                        duracion: result.routes[0].legs[0].duration.text,
                        pasos: result.routes[0].legs[0].steps
                    };
                    
                    // Actualizar información de tiempo y distancia con datos reales
                    actualizarInformacionTiempoConRuta(rutaActiva);
                    
                    // Centrar mapa en la ruta
                    const bounds = new google.maps.LatLngBounds();
                    bounds.extend({ lat: parseFloat(latRepartidor), lng: parseFloat(lngRepartidor) });
                    bounds.extend(destino);
                    map.fitBounds(bounds);
                } else {
                    console.error('Error al calcular la ruta:', status);
                }
            });
        } else {
            console.error('Error al geocodificar la dirección:', status);
        }
    });
}

// Función para actualizar información de tiempo y distancia con datos reales de la ruta
function actualizarInformacionTiempoConRuta(ruta) {
    if (ruta) {
        document.getElementById('tiempo-estimado').textContent = ruta.duracion;
        document.getElementById('distancia').textContent = ruta.distancia;
    }
}

// Función para actualizar información de tiempo y distancia
function actualizarInformacionTiempo(ubicacion) {
    // Simular cálculo de tiempo y distancia (en una implementación real, esto vendría del servidor)
    const tiempoEstimado = Math.floor(Math.random() * 15) + 5; // 5-20 minutos
    const distancia = Math.floor(Math.random() * 5) + 1; // 1-6 km
    
    document.getElementById('tiempo-estimado').textContent = `${tiempoEstimado} min`;
    document.getElementById('distancia').textContent = `${distancia} km`;
    
    // Formatear fecha de última actualización
    const fecha = new Date(ubicacion.fecha_actualizacion);
    const ahora = new Date();
    const diferencia = Math.floor((ahora - fecha) / 1000 / 60); // minutos
    
    if (diferencia < 1) {
        document.getElementById('ultima-actualizacion').textContent = 'Ahora';
    } else if (diferencia < 60) {
        document.getElementById('ultima-actualizacion').textContent = `${diferencia} min`;
    } else {
        document.getElementById('ultima-actualizacion').textContent = `${Math.floor(diferencia / 60)} h`;
    }
}

// Función para iniciar actualización automática
function iniciarActualizacionUbicacion() {
    // Actualizar inmediatamente
    actualizarUbicacionRepartidor();
    
    // Usar tiempo de actualización configurado (convertir a milisegundos)
    const tiempoActualizacion = <?= ($mapaConfig['tiempo_actualizacion'] ?? 30) * 1000 ?>;
    intervaloActualizacion = setInterval(actualizarUbicacionRepartidor, tiempoActualizacion);
}

// Función para mostrar notificaciones toast
function showToast(message, type = 'info') {
    // Crear toast dinámicamente
    const toast = document.createElement('div');
    toast.className = `toast show align-items-center text-white bg-${type} border-0`;
    toast.style.position = 'fixed';
    toast.style.top = '20px';
    toast.style.right = '20px';
    toast.style.zIndex = '1100';
    toast.style.marginBottom = '10px';
    
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="this.parentElement.parentElement.remove()"></button>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Remover después de 3 segundos
    setTimeout(() => {
        if (toast.parentElement) {
            toast.remove();
        }
    }, 3000);
}

// Función para mostrar errores del mapa
function mostrarErrorMapa(mensaje) {
    const errorDiv = document.getElementById('map-error');
    const errorMessage = document.getElementById('error-message');
    if (errorDiv && errorMessage) {
        errorMessage.textContent = mensaje;
        errorDiv.style.display = 'block';
    }
    console.error('Error del mapa:', mensaje);
}

// Función para mostrar/ocultar la ruta
function toggleRuta() {
    const btnRuta = document.getElementById('btn-ruta');
    
    if (rutaActiva && directionsRenderer) {
        if (directionsRenderer.getMap()) {
            // Ocultar ruta
            directionsRenderer.setMap(null);
            btnRuta.innerHTML = '<i class="fas fa-route"></i>';
            btnRuta.title = 'Mostrar ruta';
            btnRuta.classList.remove('btn-primary');
            btnRuta.classList.add('btn-outline-primary');
        } else {
            // Mostrar ruta
            directionsRenderer.setMap(map);
            btnRuta.innerHTML = '<i class="fas fa-route"></i>';
            btnRuta.title = 'Ocultar ruta';
            btnRuta.classList.remove('btn-outline-primary');
            btnRuta.classList.add('btn-primary');
        }
    } else {
        showToast('No hay ruta disponible para mostrar', 'info');
    }
}

// Función para mostrar mensaje cuando no hay ubicación disponible
function mostrarMensajeSinUbicacion(mensaje = 'No hay ubicación disponible del repartidor en este momento. El repartidor puede estar iniciando su ruta o la ubicación se actualizará pronto.') {
    const errorDiv = document.getElementById('map-error');
    const errorMessage = document.getElementById('error-message');
    if (errorDiv && errorMessage) {
        errorMessage.textContent = mensaje;
        errorDiv.style.display = 'block';
        errorDiv.className = 'alert alert-info m-3';
        errorDiv.innerHTML = `
            <i class="fas fa-info-circle me-2"></i>
            <strong>Ubicación no disponible:</strong> 
            <span id="error-message">${mensaje}</span>
        `;
    }
    
    // Mostrar mensaje en el mapa también
    if (map) {
        const infoWindow = new google.maps.InfoWindow({
            content: `
                <div style="padding: 10px; max-width: 250px;">
                    <h6><i class="fas fa-info-circle me-2"></i>Ubicación no disponible</h6>
                    <p class="mb-0">${mensaje}</p>
                </div>
            `
        });
        
        // Mostrar en el centro del mapa
        const center = map.getCenter();
        if (center) {
            infoWindow.setPosition(center);
            infoWindow.open(map);
            
            // Cerrar automáticamente después de 5 segundos
            setTimeout(() => {
                infoWindow.close();
            }, 5000);
        }
    }
}

// Inicialización cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    // Solo inicializar si el pedido está en camino y existe el elemento del mapa
    if ('<?= $pedido['estado'] ?>' === 'en_camino' && document.getElementById('map')) {
        // Verificar si Google Maps ya está cargado
        if (typeof google !== 'undefined' && google.maps && google.maps.Map) {
            console.log('Google Maps API ya está disponible, inicializando mapa...');
            initMap();
        } else {
            // Cargar Google Maps API si no está disponible
            console.log('Cargando Google Maps API...');
            const script = document.createElement('script');
            script.src = 'https://maps.googleapis.com/maps/api/js?key=<?= config('GoogleMaps')->apiKey ?>&libraries=geometry&loading=async';
            script.async = true;
            script.defer = true;
            script.onload = function() {
                console.log('Google Maps API cargada, inicializando mapa de seguimiento...');
                initMap();
            };
            script.onerror = function() {
                console.error('Error al cargar Google Maps API');
                mostrarErrorMapa('Error al cargar Google Maps API');
            };
            document.head.appendChild(script);
        }
    }
});

// Limpiar intervalo cuando se cierre la página
window.addEventListener('beforeunload', function() {
    if (intervaloActualizacion) {
        clearInterval(intervaloActualizacion);
    }
});
</script>

<style>
/* Variables de color para consistencia */
:root {
    --primary-color: #4281A4;
    --accent-color: #48A9A6;
    --light-color: #E4DFDA;
    --warm-color: #D4B483;
    --accent-red: #C1666B;
}

/* Estilos para seguimiento */
.seguimiento-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(66, 129, 164, 0.1);
    transition: all 0.3s ease;
}

.seguimiento-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(66, 129, 164, 0.15);
}

.seguimiento-header {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    color: white;
    border-radius: 15px 15px 0 0 !important;
    border: none;
    padding: 1.5rem;
}

.seguimiento-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.seguimiento-subtitle {
    opacity: 0.9;
    font-size: 0.9rem;
}

.seguimiento-badge {
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-weight: 500;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.badge-en-camino {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.badge-default {
    background: var(--light-color);
    color: var(--primary-color);
}

.seguimiento-section-title {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.seguimiento-info-list {
    margin-bottom: 0;
}

.seguimiento-info-item {
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(66, 129, 164, 0.1);
    color: #555;
}

.seguimiento-info-item:last-child {
    border-bottom: none;
}

.seguimiento-info-item strong {
    color: var(--primary-color);
    font-weight: 600;
}

.seguimiento-alert {
    border-radius: 12px;
    padding: 1.25rem;
    margin-bottom: 0;
}

.alert-en-camino {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.alert-default {
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    color: var(--primary-color);
    border: 1px solid rgba(66, 129, 164, 0.2);
}

.seguimiento-en-camino-card {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    border-radius: 15px;
    box-shadow: 0 6px 25px rgba(40, 167, 69, 0.3);
}

.seguimiento-timer {
    text-align: center;
    padding: 0.5rem 1rem;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    backdrop-filter: blur(10px);
}

/* Responsive */
@media (max-width: 768px) {
    .seguimiento-header {
        padding: 1rem;
    }
    
    .seguimiento-title {
        font-size: 1.1rem;
    }
    
    .seguimiento-badge {
        font-size: 0.8rem !important;
        padding: 0.4rem 0.8rem;
    }
    
    #map {
        height: 250px !important;
    }
    
    .seguimiento-timer {
        padding: 0.4rem 0.8rem;
        font-size: 0.9rem;
    }
    
    .seguimiento-section-title {
        font-size: 1rem;
    }
    
    .seguimiento-info-item {
        padding: 0.4rem 0;
        font-size: 0.9rem;
    }
    
    .seguimiento-alert {
        padding: 1rem;
    }
    
    .seguimiento-alert .fas {
        font-size: 1.2rem !important;
    }
    
    .seguimiento-alert strong {
        font-size: 1rem;
    }
    
    .seguimiento-alert small {
        font-size: 0.85rem;
    }
}

@media (max-width: 576px) {
    .seguimiento-header {
        padding: 0.75rem;
    }
    
    .seguimiento-title {
        font-size: 1rem;
    }
    
    .seguimiento-subtitle {
        font-size: 0.8rem;
    }
    
    .seguimiento-badge {
        font-size: 0.75rem !important;
        padding: 0.3rem 0.6rem;
    }
    
    #map {
        height: 200px !important;
    }
    
    .seguimiento-timer {
        padding: 0.3rem 0.6rem;
        font-size: 0.8rem;
    }
    
    .seguimiento-section-title {
        font-size: 0.9rem;
    }
    
    .seguimiento-info-item {
        padding: 0.3rem 0;
        font-size: 0.85rem;
    }
    
    .seguimiento-alert {
        padding: 0.75rem;
    }
    
    .seguimiento-alert .fas {
        font-size: 1rem !important;
    }
    
    .seguimiento-alert strong {
        font-size: 0.9rem;
    }
    
    .seguimiento-alert small {
        font-size: 0.8rem;
    }
}
</style>

<!-- Google Maps Script -->
<?= google_maps_script('places,geometry,directions') ?> 