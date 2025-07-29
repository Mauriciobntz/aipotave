<div class="container mt-5 pt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Progreso del checkout -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="steps">
                        <div class="step completed">
                            <div class="step-number">1</div>
                            <div class="step-label">Carrito</div>
                        </div>
                        <div class="step active">
                            <div class="step-number">2</div>
                            <div class="step-label">Datos</div>
                        </div>
                        <div class="step">
                            <div class="step-number">3</div>
                            <div class="step-label">Confirmación</div>
                        </div>
                        <div class="step">
                            <div class="step-number">4</div>
                            <div class="step-label">Pago</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <!-- Resumen del pedido -->
                <div class="col-lg-5 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white">
                            <h5 class="mb-0 fw-bold">
                                <i class="fas fa-shopping-cart me-2"></i>Resumen del Pedido
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($carrito as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if (!empty($item['imagen'])): ?>
                                                        <img src="<?= base_url('public/' . $item['imagen']) ?>" class="rounded me-2" width="50" height="50" alt="<?= esc($item['nombre']) ?>">
                                                    <?php else: ?>
                                                        <div class="rounded me-2 bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                            <i class="fas fa-utensils text-muted"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <h6 class="mb-0"><?= esc($item['nombre']) ?></h6>
                                                        <small class="text-muted">$<?= number_format($item['precio'], 2) ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= esc($item['cantidad']) ?></td>
                                            <td>$<?= number_format($item['precio'] * $item['cantidad'], 2) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="border-top pt-3">
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <span class="text-muted">Subtotal:</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <span class="fw-bold">$<?= number_format($subtotal, 2) ?></span>
                                    </div>
                                </div>
                                
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <span class="text-muted">Envío:</span>
                                        <small class="d-block text-muted" id="distancia-texto">Calculando distancia...</small>
                                    </div>
                                    <div class="col-6 text-end">
                                        <span class="fw-bold text-success" id="costo-envio">$<?= number_format($envio, 2) ?></span>
                                        <small class="d-block text-muted" id="tarifa-info">Hasta 1.5 km</small>
                                    </div>
                                </div>
                                
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <span class="text-muted">Descuento:</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <span class="fw-bold text-danger">$0.00</span>
                                    </div>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <span class="fw-bold fs-5">Total:</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <span class="fw-bold fs-5 text-primary">$<?= number_format($total, 2) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Formulario de envío -->
                <div class="col-lg-7">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0 fw-bold">
                                <i class="fas fa-truck me-2"></i>Datos de Entrega
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('checkout/procesar') ?>" method="post" id="checkoutForm">
                                <!-- Campos ocultos para coordenadas -->
                                <input type="hidden" id="latitud" name="latitud" value="">
                                <input type="hidden" id="longitud" name="longitud" value="">
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="nombre" class="form-label">Nombre completo *</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required minlength="3" value="<?= old('nombre') ?>">
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="celular" class="form-label">Celular *</label>
                                        <input type="tel" class="form-control" id="celular" name="celular" required value="<?= old('celular') ?>">
                                    </div>
                                    
                                    <div class="col-12">
                                        <label for="email" class="form-label">Correo electrónico</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>">
                                    </div>
                                    
                                    <div class="col-12">
                                        <label for="direccion" class="form-label">Dirección de entrega *</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="direccion" name="direccion" required value="<?= old('direccion') ?>" placeholder="Ingresa tu dirección o selecciónala en el mapa">
                                            <button type="button" class="btn btn-outline-secondary" onclick="obtenerUbicacionActual()">
                                                <i class="fas fa-location-arrow me-1"></i>Mi Ubicación
                                            </button>
                                        </div>
                                        <small class="text-muted">Selecciona tu ubicación exacta en el mapa para una entrega más precisa</small>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="entre" class="form-label">Entre calles</label>
                                        <input type="text" class="form-control" id="entre" name="entre" value="<?= old('entre') ?>" placeholder="Ej: Av. Corrientes y Av. Pueyrredón">
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="referencia" class="form-label">Referencia</label>
                                        <input type="text" class="form-control" id="referencia" name="referencia" value="<?= old('referencia') ?>" placeholder="Ej: Portón negro, timbre azul">
                                    </div>
                                    
                                    <div class="col-12">
                                        <label class="form-label">Selecciona tu ubicación en el mapa</label>
                                        <div id="map" style="height: 300px; width: 100%; border-radius: 8px; border: 1px solid #dee2e6;"></div>
                                        <small class="text-muted">Haz clic en el mapa para marcar tu ubicación exacta</small>
                                        
                                        <!-- Información de tarifas -->
                                        <div class="mt-3 p-3 bg-light rounded">
                                            <h6 class="mb-2"><i class="fas fa-info-circle me-2"></i>Tarifas de Envío</h6>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="badge bg-success me-2">$1,000</div>
                                                        <small>Hasta 1.5 km</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="badge bg-warning me-2">$1,500</div>
                                                        <small>Más de 1.5 km</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <small class="text-muted">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                Restaurante ubicado en Clorinda, Formosa
                                            </small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <label for="observaciones" class="form-label">Observaciones</label>
                                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Ej: sin mayonesa, llamar al llegar, instrucciones especiales..."><?= old('observaciones') ?></textarea>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="metodo_pago" class="form-label">Método de pago *</label>
                                        <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                                            <option value="">Selecciona una opción</option>
                                            <option value="efectivo" <?= old('metodo_pago') === 'efectivo' ? 'selected' : '' ?>>Efectivo</option>
                                            <option value="tarjeta" <?= old('metodo_pago') === 'tarjeta' ? 'selected' : '' ?>>Tarjeta</option>
                                            <option value="transferencia" <?= old('metodo_pago') === 'transferencia' ? 'selected' : '' ?>>Transferencia</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-12 mt-4">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary btn-lg btn-hover-effect">
                                                <i class="fas fa-credit-card me-2"></i>Continuar al Pago
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluir Google Maps -->
<?= google_maps_script('places') ?>

<script>
let map;
let marker;
let ubicacionSeleccionada = null;
let autocomplete;

// Inicializar mapa cuando la página carga
function initMap() {
    // Centrar en Clorinda, Formosa
    map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: -25.291388888889, lng: -57.718333333333 },
        zoom: 13,
        mapTypeControl: false,
        streetViewControl: false,
        fullscreenControl: true
    });
    
    // Manejar clics en el mapa
    map.addListener('click', function(e) {
        const lat = e.latLng.lat();
        const lng = e.latLng.lng();
        
        // Actualizar marcador
        if (marker) {
            marker.setMap(null);
        }
        marker = new google.maps.Marker({
            position: { lat: lat, lng: lng },
            map: map,
            title: 'Ubicación seleccionada'
        });
        
        // Actualizar campos ocultos
        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lng;
        
        // Obtener dirección usando geocodificación inversa
        obtenerDireccionDesdeCoordenadas(lat, lng);
        
        ubicacionSeleccionada = { lat: lat, lng: lng };
    });
    
    // Configurar autocompletado para el campo de dirección
    const direccionInput = document.getElementById('direccion');
    autocomplete = new google.maps.places.Autocomplete(direccionInput, {
        types: ['address'],
        componentRestrictions: { country: 'AR' }
    });
    
    // Manejar selección del autocompletado
    autocomplete.addListener('place_changed', function() {
        const place = autocomplete.getPlace();
        
        if (place.geometry) {
            const lat = place.geometry.location.lat();
            const lng = place.geometry.location.lng();
            
            // Centrar mapa en la ubicación seleccionada
            map.setCenter({ lat: lat, lng: lng });
            map.setZoom(16);
            
            // Actualizar marcador
            if (marker) {
                marker.setMap(null);
            }
            marker = new google.maps.Marker({
                position: { lat: lat, lng: lng },
                map: map,
                title: place.formatted_address
            });
            
            // Actualizar campos ocultos
            document.getElementById('latitud').value = lat;
            document.getElementById('longitud').value = lng;
            
                    ubicacionSeleccionada = { lat: lat, lng: lng };
        
        // Calcular costo de envío
        calcularCostoEnvio(lat, lng);
        
        // Mostrar mensaje de éxito
        showToast('Dirección seleccionada correctamente', 'success');
        }
    });
    
    // Si hay valores antiguos, centrar el mapa ahí
    <?php if (old('latitud') && old('longitud')): ?>
        const lat = <?= old('latitud') ?>;
        const lng = <?= old('longitud') ?>;
        map.setCenter({ lat: lat, lng: lng });
        map.setZoom(16);
        marker = new google.maps.Marker({
            position: { lat: lat, lng: lng },
            map: map,
            title: 'Ubicación anterior'
        });
        ubicacionSeleccionada = { lat: lat, lng: lng };
    <?php endif; ?>
}

// Función para obtener ubicación actual del usuario
function obtenerUbicacionActual() {
    if (navigator.geolocation) {
        // Mostrar indicador de carga
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Obteniendo...';
        btn.disabled = true;
        
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                // Centrar mapa en la ubicación actual
                map.setCenter({ lat: lat, lng: lng });
                map.setZoom(16);
                
                // Agregar marcador
                if (marker) {
                    marker.setMap(null);
                }
                marker = new google.maps.Marker({
                    position: { lat: lat, lng: lng },
                    map: map,
                    title: 'Tu ubicación actual'
                });
                
                // Obtener dirección
                obtenerDireccionDesdeCoordenadas(lat, lng);
                
                // Actualizar campos ocultos
                document.getElementById('latitud').value = lat;
                document.getElementById('longitud').value = lng;
                
                ubicacionSeleccionada = { lat: lat, lng: lng };
                
                // Calcular costo de envío
                calcularCostoEnvio(lat, lng);
                
                // Restaurar botón
                btn.innerHTML = originalText;
                btn.disabled = false;
                
                // Mostrar mensaje de éxito
                showToast('Ubicación obtenida correctamente', 'success');
            },
            function(error) {
                console.error('Error al obtener ubicación:', error);
                
                // Restaurar botón
                btn.innerHTML = originalText;
                btn.disabled = false;
                
                // Mostrar mensaje de error
                let mensaje = 'Error al obtener tu ubicación';
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        mensaje = 'Permiso denegado. Por favor, permite el acceso a tu ubicación.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        mensaje = 'Información de ubicación no disponible.';
                        break;
                    case error.TIMEOUT:
                        mensaje = 'Tiempo de espera agotado al obtener la ubicación.';
                        break;
                }
                showToast(mensaje, 'danger');
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 300000 // 5 minutos
            }
        );
    } else {
        showToast('La geolocalización no está disponible en tu navegador', 'warning');
    }
}

// Función para obtener dirección desde coordenadas
function obtenerDireccionDesdeCoordenadas(lat, lng) {
    // Usar Google Maps Geocoding API
    const geocoder = new google.maps.Geocoder();
    const latlng = { lat: parseFloat(lat), lng: parseFloat(lng) };
    
    geocoder.geocode({ location: latlng }, function(results, status) {
        if (status === 'OK' && results[0]) {
            document.getElementById('direccion').value = results[0].formatted_address;
            showToast('Dirección obtenida automáticamente', 'success');
        } else {
            console.error('Error al obtener dirección:', status);
            document.getElementById('direccion').value = `${lat}, ${lng}`;
        }
    });
}

// Función para mostrar mensajes
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
    
    // Auto-ocultar después de 5 segundos
    setTimeout(() => {
        toast.classList.remove('show');
        toast.classList.add('hide');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 5000);
}

// Validar que se haya seleccionado una ubicación antes de enviar
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    const direccion = document.getElementById('direccion').value.trim();
    const latitud = document.getElementById('latitud').value;
    const longitud = document.getElementById('longitud').value;
    
    if (!direccion) {
        e.preventDefault();
        showToast('Por favor, ingresa tu dirección de entrega', 'warning');
        document.getElementById('direccion').focus();
        return false;
    }
    
    // Si no hay coordenadas pero sí dirección, mostrar advertencia
    if (!latitud || !longitud) {
        const confirmar = confirm('No has seleccionado una ubicación exacta en el mapa. ¿Deseas continuar con solo la dirección escrita?');
        if (!confirmar) {
            e.preventDefault();
            return false;
        }
        showToast('Se recomienda seleccionar tu ubicación exacta en el mapa para una mejor entrega', 'info');
    } else {
        showToast('Ubicación exacta seleccionada. ¡Perfecto para la entrega!', 'success');
    }
    
    // Mostrar spinner en el botón de enviar
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Procesando...';
    submitBtn.disabled = true;
});

// Función para calcular costo de envío basado en distancia
function calcularCostoEnvio(lat, lng) {
    // Coordenadas del restaurante (Clorinda, Formosa)
    const latRestaurante = -25.291388888889;
    const lngRestaurante = -57.718333333333;
    
    // Calcular distancia usando la fórmula de Haversine
    const distancia = calcularDistancia(latRestaurante, lngRestaurante, lat, lng);
    
    // Determinar costo según distancia
    let costoEnvio;
    let tarifaInfo;
    
    if (distancia <= 1.5) {
        costoEnvio = 1000;
        tarifaInfo = 'Hasta 1.5 km';
    } else {
        costoEnvio = 1500;
        tarifaInfo = 'Más de 1.5 km';
    }
    
    // Actualizar elementos en la página
    document.getElementById('costo-envio').textContent = '$' + costoEnvio.toLocaleString();
    document.getElementById('tarifa-info').textContent = tarifaInfo;
    document.getElementById('distancia-texto').textContent = formatearDistancia(distancia);
    
    // Actualizar total
    actualizarTotal(costoEnvio);
}

// Función para calcular distancia usando fórmula de Haversine
function calcularDistancia(lat1, lng1, lat2, lng2) {
    const radioTierra = 6371; // Radio de la Tierra en km
    
    // Convertir a radianes
    const lat1Rad = lat1 * Math.PI / 180;
    const lng1Rad = lng1 * Math.PI / 180;
    const lat2Rad = lat2 * Math.PI / 180;
    const lng2Rad = lng2 * Math.PI / 180;
    
    // Diferencias
    const deltaLat = lat2Rad - lat1Rad;
    const deltaLng = lng2Rad - lng1Rad;
    
    // Fórmula de Haversine
    const a = Math.sin(deltaLat / 2) * Math.sin(deltaLat / 2) +
               Math.cos(lat1Rad) * Math.cos(lat2Rad) *
               Math.sin(deltaLng / 2) * Math.sin(deltaLng / 2);
    
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    
    return radioTierra * c;
}

// Función para formatear distancia
function formatearDistancia(distancia) {
    if (distancia < 1) {
        return Math.round(distancia * 1000) + ' metros';
    } else {
        return distancia.toFixed(1) + ' km';
    }
}

// Función para actualizar el total
function actualizarTotal(costoEnvio) {
    const subtotal = <?= $subtotal ?? 0 ?>;
    const descuento = 0;
    const total = subtotal + costoEnvio - descuento;
    
    // Actualizar el total en la página
    const totalElement = document.querySelector('.fw-bold.fs-5.text-primary');
    if (totalElement) {
        totalElement.textContent = '$' + total.toLocaleString();
    }
}

// Llamar a initMap cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    // Esperar a que Google Maps se cargue completamente
    if (typeof google !== 'undefined' && google.maps) {
        initMap();
    } else {
        // Si Google Maps aún no se ha cargado, esperar
        window.addEventListener('load', function() {
            if (typeof google !== 'undefined' && google.maps) {
                initMap();
            }
        });
    }
});
</script>

<style>
.steps {
    display: flex;
    justify-content: space-between;
    position: relative;
    margin: 0 auto;
    max-width: 800px;
}

.steps:before {
    content: '';
    position: absolute;
    top: 20px;
    left: 0;
    right: 0;
    height: 2px;
    background-color: #e9ecef;
    z-index: 1;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    z-index: 2;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #e9ecef;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-bottom: 8px;
}

.step-label {
    font-size: 14px;
    color: #6c757d;
    text-align: center;
}

.step.active .step-number {
    background-color: #0d6efd;
    color: white;
}

.step.active .step-label {
    color: #0d6efd;
    font-weight: 500;
}

.step.completed .step-number {
    background-color: #198754;
    color: white;
}

.step.completed .step-label {
    color: #198754;
    font-weight: 500;
}

#map {
    transition: all 0.3s ease;
}

#map:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.toast {
    transition: all 0.3s ease;
}

.toast.show {
    opacity: 1;
}

.toast.hide {
    opacity: 0;
}
</style>