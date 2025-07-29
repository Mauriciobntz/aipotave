<div class="container-fluid mt-3">
    <!-- Header del seguimiento -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">
                                <i class="fas fa-motorcycle me-2"></i>Seguimiento en Tiempo Real
                            </h5>
                            <small>Pedido #<?= esc($pedido['codigo_seguimiento']) ?></small>
                        </div>
                        <div class="text-end">
                            <div class="badge <?= $pedido['estado'] == 'en_camino' ? 'bg-success' : 'bg-light text-dark' ?> fs-6" 
                                 style="<?= $pedido['estado'] == 'en_camino' ? 'background: linear-gradient(135deg, #28a745, #20c997) !important; color: white !important;' : '' ?>">
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
                        <div class="col-md-6">
                            <h6><i class="fas fa-info-circle me-2"></i>Información del Pedido</h6>
                            <ul class="list-unstyled">
                                <li><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?></li>
                                <li><strong>Total:</strong> $<?= esc($pedido['total']) ?></li>
                                <li><strong>Dirección:</strong> <?= esc($pedido['direccion_entrega']) ?></li>
                                <?php if (!empty($pedido['repartidor_nombre'])): ?>
                                    <li><strong>Repartidor:</strong> <?= esc($pedido['repartidor_nombre']) ?></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-clock me-2"></i>Estado Actual</h6>
                            <div class="alert <?= $pedido['estado'] == 'en_camino' ? 'alert-success' : 'alert-info' ?> border-0" 
                                 style="<?= $pedido['estado'] == 'en_camino' ? 'background: linear-gradient(135deg, #28a745, #20c997); color: white;' : '' ?>">
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        <?php if ($pedido['estado'] == 'en_camino'): ?>
                                            <i class="fas fa-motorcycle fa-lg"></i>
                                        <?php else: ?>
                                            <i class="fas fa-info-circle fa-lg"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <strong><?= ucfirst($pedido['estado']) ?></strong>
                                        <br>
                                        <small>
                                            <?php
                                            switch($pedido['estado']) {
                                                case 'pendiente':
                                                    echo '<i class="fas fa-clock me-1"></i>Tu pedido está siendo procesado';
                                                    break;
                                                case 'confirmado':
                                                    echo '<i class="fas fa-check-circle me-1"></i>Tu pedido ha sido confirmado y está en preparación';
                                                    break;
                                                case 'en_preparacion':
                                                    echo '<i class="fas fa-utensils me-1"></i>Tu pedido está siendo preparado en la cocina';
                                                    break;
                                                case 'en_camino':
                                                    echo '<i class="fas fa-motorcycle me-1"></i>Estado: En camino hacia tu dirección';
                                                    break;
                                                case 'entregado':
                                                    echo '<i class="fas fa-check-double me-1"></i>Tu pedido ha sido entregado exitosamente';
                                                    break;
                                                default:
                                                    echo '<i class="fas fa-info-circle me-1"></i>Estado del pedido actualizado';
                                            }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
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
            <div class="card border-0" style="background: linear-gradient(135deg, #28a745, #20c997); color: white; border-radius: 12px;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-motorcycle fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold">🚚 En Camino</h5>
                                <p class="mb-0">El repartidor se dirige hacia tu dirección</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="badge bg-white text-success fs-6">
                                <i class="fas fa-motorcycle me-1"></i>En Camino
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
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold">⏳ Pendiente</h5>
                                <p class="mb-0">Tu pedido está siendo procesado</p>
                            </div>
                        </div>
                        <div class="text-end">
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
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold">✅ Confirmado</h5>
                                <p class="mb-0">Tu pedido ha sido confirmado y está en preparación</p>
                            </div>
                        </div>
                        <div class="text-end">
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
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-utensils fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold">👨‍🍳 En Preparación</h5>
                                <p class="mb-0">Tu pedido está siendo preparado en la cocina</p>
                            </div>
                        </div>
                        <div class="text-end">
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
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-check-double fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold">🎉 Entregado</h5>
                                <p class="mb-0">Tu pedido ha sido entregado exitosamente</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="badge bg-white text-purple fs-6">
                                <i class="fas fa-check-double me-1"></i>Entregado
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Indicador permanente de estado en camino -->
    <?php if ($pedido['estado'] == 'en_camino'): ?>
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-info border-0" style="background: linear-gradient(135deg, #FF6B35, #FF8A65); color: white; border-radius: 12px;">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-motorcycle fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-bold">📍 Seguimiento en Tiempo Real</h6>
                        <p class="mb-0 small">Puedes seguir la ubicación del repartidor en el mapa de abajo</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Indicador de progreso visual -->
    <?php if ($pedido['estado'] == 'en_camino'): ?>
    <div class="row mb-3">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef);">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="spinner-border spinner-border-sm text-success" role="status">
                                    <span class="visually-hidden">Cargando...</span>
                                </div>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold text-success">🔄 Seguimiento Activo</h6>
                                <p class="mb-0 small text-muted">Actualizando ubicación del repartidor en tiempo real</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <small class="text-muted">Actualizado cada 30 segundos</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Mapa de seguimiento -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">
                            <i class="fas fa-map-marked-alt me-2"></i>Ubicación del Repartidor
                        </h6>
                        <div class="btn-group btn-group-sm">
                            <button onclick="toggleRuta()" class="btn btn-outline-primary btn-sm" id="btn-ruta" title="Mostrar/Ocultar ruta">
                                <i class="fas fa-route"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="map" style="height: 400px; width: 100%;"></div>
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
                        <div class="col-md-4 text-center">
                            <div class="border-end">
                                <h6 class="text-muted">Tiempo Estimado</h6>
                                <h4 id="tiempo-estimado" class="text-primary">--</h4>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="border-end">
                                <h6 class="text-muted">Distancia</h6>
                                <h4 id="distancia" class="text-info">--</h4>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <h6 class="text-muted">Última Actualización</h6>
                            <h4 id="ultima-actualizacion" class="text-success">--</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
    border-bottom: none;
}

#map {
    border-radius: 0 0 12px 12px;
}

.badge {
    font-size: 0.875rem;
    padding: 0.5rem 1rem;
}

.alert {
    border-radius: 8px;
    border: none;
}
</style>

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
            
            map = new google.maps.Map(document.getElementById('map'), {
                center: center,
                zoom: 15,
                mapTypeControl: false,
                streetViewControl: false,
                fullscreenControl: true
            });
            
            // Inicializar servicios de direcciones
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer({
                suppressMarkers: true, // No mostrar marcadores automáticos
                polylineOptions: {
                    strokeColor: '#FF6B35',
                    strokeWeight: 4,
                    strokeOpacity: 0.8
                }
            });
            directionsRenderer.setMap(map);
            
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
        .then(response => response.json())
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
            }
        })
        .catch(error => {
            console.error('Error al obtener ubicación del repartidor:', error);
        });
}

// Función para calcular la ruta del repartidor
function calcularRutaRepartidor(latRepartidor, lngRepartidor) {
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
    
    // Actualizar cada 30 segundos
    intervaloActualizacion = setInterval(actualizarUbicacionRepartidor, 30000);
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

// Inicialización cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar mapa cuando Google Maps esté listo
    function initializeMapWhenReady() {
        if (typeof google !== 'undefined' && google.maps && google.maps.Map) {
            console.log('Google Maps API cargada, inicializando mapa de seguimiento...');
            initMap();
        } else {
            console.log('Google Maps API aún no está disponible, esperando...');
            setTimeout(initializeMapWhenReady, 100);
        }
    }
    
    initializeMapWhenReady();
});

// Limpiar intervalo cuando se cierre la página
window.addEventListener('beforeunload', function() {
    if (intervaloActualizacion) {
        clearInterval(intervaloActualizacion);
    }
});
</script>

<!-- Google Maps Script -->
<?= google_maps_script('places,geometry,directions') ?> 