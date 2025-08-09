<div class="container mt-5 pt-5 mb-5">
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
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Progreso del checkout -->
            <div class="card shadow-sm mb-4 checkout-progress-card">
                <div class="card-body">
                    <div class="steps checkout-steps">
                        <div class="step completed checkout-step">
                            <div class="step-number checkout-step-number">1</div>
                            <div class="step-label checkout-step-label">Carrito</div>
                        </div>
                        <div class="step active checkout-step">
                            <div class="step-number checkout-step-number">2</div>
                            <div class="step-label checkout-step-label">Datos</div>
                        </div>
                        <div class="step checkout-step">
                            <div class="step-number checkout-step-number">3</div>
                            <div class="step-label checkout-step-label">Confirmación</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
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
                                    <div class="col-12 col-md-6">
                                        <label for="nombre" class="form-label">Nombre completo *</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required minlength="3" value="<?= old('nombre') ?>" inputmode="text" autocomplete="name">
                                    </div>
                                    
                                    <div class="col-12 col-md-6">
                                        <label for="celular" class="form-label">Celular *</label>
                                        <input type="tel" class="form-control" id="celular" name="celular" required value="<?= old('celular') ?>" inputmode="tel" autocomplete="tel">
                                    </div>
                                    
                                    <div class="col-12">
                                        <label for="email" class="form-label">Correo electrónico</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" inputmode="email" autocomplete="email">
                                    </div>
                                    
                                    <div class="col-12">
                                        <label for="direccion" class="form-label">Dirección de entrega *</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="direccion" name="direccion" required value="<?= old('direccion') ?>" placeholder="Ingresa tu dirección o selecciónala en el mapa" inputmode="text" autocomplete="street-address">
                                            <button type="button" class="btn btn-outline-secondary" onclick="obtenerUbicacionActual()">
                                                <i class="fas fa-location-arrow me-1"></i>Mi Ubicación
                                            </button>
                                        </div>
                                        <small class="text-muted">Selecciona tu ubicación exacta en el mapa para una entrega más precisa</small>
                                    </div>
                                    
                                    <div class="col-12 col-md-6">
                                        <label for="entre" class="form-label">Entre calles</label>
                                        <input type="text" class="form-control" id="entre" name="entre" value="<?= old('entre') ?>" placeholder="Ej: Av. Corrientes y Av. Pueyrredón" inputmode="text">
                                    </div>
                                    
                                    <div class="col-12 col-md-6">
                                        <label for="referencia" class="form-label">Referencia</label>
                                        <input type="text" class="form-control" id="referencia" name="referencia" value="<?= old('referencia') ?>" placeholder="Ej: Portón negro, timbre azul" inputmode="text">
                                    </div>
                                    
                                    <div class="col-12">
                                        <label class="form-label">Selecciona tu ubicación en el mapa</label>
                                        <div id="map" style="height: 300px; width: 100%; border-radius: 8px; border: 1px solid #dee2e6;"></div>
                                        <small class="text-muted">Haz clic en el mapa para marcar tu ubicación exacta</small>
                                        
                                    </div>
                                    
                                    <div class="col-12">
                                        <label for="observaciones" class="form-label">Observaciones</label>
                                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Ej: sin mayonesa, llamar al llegar, instrucciones especiales..."><?= old('observaciones') ?></textarea>
                                    </div>
                                    
                                    <div class="col-12 col-md-6">
                                        <label for="metodo_pago" class="form-label">Método de pago *</label>
                                        <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                                            <option value="">Selecciona una opción</option>
                                            <option value="efectivo" <?= old('metodo_pago') === 'efectivo' ? 'selected' : '' ?>>Efectivo</option>
                                            <option value="transferencia" <?= old('metodo_pago') === 'transferencia' ? 'selected' : '' ?>>Transferencia</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-12 mt-4">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary btn-lg btn-hover-effect checkout-confirm-btn">
                                                <i class="fas fa-check-circle me-2"></i>Confirmar Datos
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Resumen del pedido -->
                <div class="col-lg-5 mb-4">
                    <div class="card shadow-sm h-100 checkout-summary-card">
                        <div class="card-header bg-white checkout-summary-header">
                            <h5 class="mb-0 fw-bold checkout-summary-title">
                                <i class="fas fa-shopping-cart me-2"></i>Resumen del Pedido
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle checkout-table">
                                    <thead>
                                        <tr>
                                            <th class="checkout-table-header">Producto</th>
                                            <th class="checkout-table-header">Cantidad</th>
                                            <th class="checkout-table-header">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($carrito as $item): ?>
                                        <tr class="checkout-table-row">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if (!empty($item['imagen'])): ?>
                                                        <img src="<?= base_url('public/' . $item['imagen']) ?>" class="rounded me-2 checkout-product-img" width="50" height="50" alt="<?= esc($item['nombre']) ?>">
                                                    <?php else: ?>
                                                        <div class="rounded me-2 bg-light d-flex align-items-center justify-content-center checkout-product-placeholder" style="width: 50px; height: 50px;">
                                                            <i class="fas fa-utensils text-muted"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <h6 class="mb-0 checkout-product-name"><?= esc($item['nombre']) ?></h6>
                                                        <small class="text-muted checkout-product-price">$<?= number_format($item['precio'], 2) ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="checkout-quantity"><?= esc($item['cantidad']) ?></td>
                                            <td class="checkout-subtotal">$<?= number_format($item['precio'] * $item['cantidad'], 2) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="border-top pt-3 checkout-totals">
                                <div class="row mb-2 checkout-total-row">
                                    <div class="col-6">
                                        <span class="text-muted checkout-total-label">Subtotal:</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <span class="fw-bold checkout-total-value">$<?= number_format($subtotal, 2) ?></span>
                                    </div>
                                </div>
                                
                                <div class="row mb-2 checkout-total-row">
                                    <div class="col-6">
                                        <span class="text-muted checkout-total-label">Envío:</span>
                                        <small class="d-block text-muted" id="distancia-texto">Selecciona tu ubicación</small>
                                    </div>
                                    <div class="col-6 text-end">
                                        <span class="fw-bold text-success" id="costo-envio">$0.00</span>
                                        <small class="d-block text-muted" id="tarifa-info" style="display: none;"></small>
                                    </div>
                                </div>
                                
                                <div class="row mb-2 checkout-total-row">
                                    <div class="col-6">
                                        <span class="text-muted checkout-total-label">Descuento:</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <span class="fw-bold text-danger">$0.00</span>
                                    </div>
                                </div>
                                
                                <div class="row mt-3 checkout-total-row">
                                    <div class="col-6">
                                        <span class="fw-bold checkout-total-label">Total:</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <span class="fw-bold fs-5 text-primary checkout-total-final">$<?= number_format($subtotal, 2) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluir Google Maps -->
<?= google_maps_script('places,directions') ?>

<script>
let map;
let marker;
let ubicacionSeleccionada = null;
let autocomplete;

// Inicializar mapa cuando la página carga
function initMap() {
    console.log('Inicializando mapa...');
    
    // Centrar en el punto de partida desde configuración
    const latRestaurante = <?= $configuracionModel->getPuntoPartidaLatitud() ?>;
    const lngRestaurante = <?= $configuracionModel->getPuntoPartidaLongitud() ?>;
    
    console.log('Coordenadas del restaurante para el mapa:', latRestaurante, lngRestaurante);
    
    map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: latRestaurante, lng: lngRestaurante },
        zoom: 13,
        mapTypeControl: false,
        streetViewControl: false,
        fullscreenControl: true
    });
    
    // Manejar clics en el mapa
    map.addListener('click', function(e) {
        const lat = e.latLng.lat();
        const lng = e.latLng.lng();
        
        console.log('Clic en el mapa:', lat, lng);
        
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
        
        // Calcular costo de envío
        console.log('Llamando a calcularCostoEnvio desde clic del mapa');
        calcularCostoEnvio(lat, lng);
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
    console.log('Calculando costo de envío para:', lat, lng);
    
    // Mostrar "Calculando distancia..." mientras se procesa
    const distanciaTextoElement = document.getElementById('distancia-texto');
    if (distanciaTextoElement) {
        distanciaTextoElement.textContent = 'Calculando distancia...';
    }
    
    // Coordenadas del restaurante desde configuración
    const latRestaurante = <?= $configuracionModel->getPuntoPartidaLatitud() ?>;
    const lngRestaurante = <?= $configuracionModel->getPuntoPartidaLongitud() ?>;
    
    console.log('Coordenadas del restaurante:', latRestaurante, lngRestaurante);
    
    // Calcular distancia usando Google Maps Directions API (ruta real)
    calcularDistanciaRuta(latRestaurante, lngRestaurante, lat, lng);
}

// Función para calcular distancia usando Google Maps Directions API
function calcularDistanciaRuta(latOrigen, lngOrigen, latDestino, lngDestino) {
    // Verificar que Google Maps esté disponible
    if (typeof google === 'undefined' || !google.maps || !google.maps.DirectionsService) {
        console.warn('Google Maps API no disponible, usando cálculo en línea recta');
        const distanciaLineaRecta = calcularDistancia(latOrigen, lngOrigen, latDestino, lngDestino);
        actualizarCostoEnvio(distanciaLineaRecta, true);
        return;
    }
    
    const directionsService = new google.maps.DirectionsService();
    
    const request = {
        origin: { lat: latOrigen, lng: lngOrigen },
        destination: { lat: latDestino, lng: lngDestino },
        travelMode: google.maps.TravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.METRIC
    };
    
    directionsService.route(request, function(result, status) {
        if (status === 'OK') {
            const ruta = result.routes[0];
            const distanciaKm = ruta.legs[0].distance.value / 1000; // Convertir metros a km
            
            // Actualizar costo de envío
            actualizarCostoEnvio(distanciaKm, false);
            
        } else {
            // Si falla la API, usar cálculo en línea recta como respaldo
            console.warn('Error al calcular ruta:', status);
            const distanciaLineaRecta = calcularDistancia(latOrigen, lngOrigen, latDestino, lngDestino);
            actualizarCostoEnvio(distanciaLineaRecta, true);
        }
    });
}

// Función para actualizar el costo de envío
function actualizarCostoEnvio(distanciaKm, esLineaRecta = false) {
    console.log('Actualizando costo de envío:', distanciaKm, 'km, línea recta:', esLineaRecta);
    
                    // Calcular costo usando la API del servidor
        const formData = new FormData();
        formData.append('distancia', distanciaKm);
        
        fetch('<?= base_url('envio/calcular-costo') ?>', {
            method: 'POST',
            body: formData
        })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response ok:', response.ok);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            const costoEnvio = data.costo;
            const tarifa = data.tarifa;
            
            console.log('Costo de envío calculado:', costoEnvio);
            console.log('Tarifa aplicada:', tarifa);
            
            // Actualizar elementos en la página
            const costoEnvioElement = document.getElementById('costo-envio');
            const distanciaTextoElement = document.getElementById('distancia-texto');
            const tarifaInfoElement = document.getElementById('tarifa-info');
            
            if (costoEnvioElement) {
                costoEnvioElement.textContent = '$' + costoEnvio.toLocaleString();
                console.log('Elemento costo-envio actualizado');
            } else {
                console.warn('Elemento costo-envio no encontrado');
            }
            
            if (distanciaTextoElement) {
                const sufijo = esLineaRecta ? ' (línea recta)' : '';
                distanciaTextoElement.textContent = formatearDistancia(distanciaKm) + sufijo;
                console.log('Elemento distancia-texto actualizado');
            } else {
                console.warn('Elemento distancia-texto no encontrado');
            }
            
            // Actualizar información de tarifa
            if (tarifaInfoElement && tarifa) {
                tarifaInfoElement.textContent = tarifa.nombre;
                tarifaInfoElement.style.display = 'block';
            }
            
            // Actualizar total
            actualizarTotal(costoEnvio);
            
        } else {
            console.error('Error al calcular costo:', data.message);
            // Fallback al cálculo anterior
            calcularCostoFallback(distanciaKm, esLineaRecta);
        }
    })
    .catch(error => {
        console.error('Error en la petición:', error);
        // Fallback al cálculo anterior
        calcularCostoFallback(distanciaKm, esLineaRecta);
    });
}

// Función de fallback para el cálculo de costo
function calcularCostoFallback(distanciaKm, esLineaRecta = false) {
    console.log('Usando cálculo de fallback');
    
    // Determinar costo según distancia (lógica anterior)
    let costoEnvio;
    let tarifaInfo;
    const tarifaInfoElement = document.getElementById('tarifa-info');
    
    if (distanciaKm <= 1.5) {
        costoEnvio = 1000;
        tarifaInfo = 'Hasta 1.5 km';
        if (tarifaInfoElement) {
            tarifaInfoElement.style.display = 'none';
        }
    } else {
        costoEnvio = 1500;
        tarifaInfo = 'Más de 1.5 km';
        if (tarifaInfoElement) {
            tarifaInfoElement.style.display = 'block';
            tarifaInfoElement.textContent = tarifaInfo;
        }
    }
    
    // Actualizar elementos en la página
    const costoEnvioElement = document.getElementById('costo-envio');
    const distanciaTextoElement = document.getElementById('distancia-texto');
    
    if (costoEnvioElement) {
        costoEnvioElement.textContent = '$' + costoEnvio.toLocaleString();
    }
    
    if (distanciaTextoElement) {
        const sufijo = esLineaRecta ? ' (línea recta)' : '';
        distanciaTextoElement.textContent = formatearDistancia(distanciaKm) + sufijo;
    }
    
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
    console.log('Actualizando total con costo de envío:', costoEnvio);
    
    // Convertir a números para asegurar que la suma sea correcta
    const subtotal = parseFloat(<?= $subtotal ?? 0 ?>);
    const descuento = 0;
    const costoEnvioNum = parseFloat(costoEnvio);
    const total = subtotal + costoEnvioNum - descuento;
    
    console.log('Subtotal:', subtotal, 'Costo envío:', costoEnvioNum, 'Total:', total);
    
    // Actualizar el total en la página
    const totalElement = document.querySelector('.checkout-total-final');
    if (totalElement) {
        totalElement.textContent = '$' + total.toLocaleString('es-AR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        console.log('Total actualizado en el DOM');
    } else {
        console.warn('Elemento checkout-total-final no encontrado');
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
/* Variables de color para consistencia */
:root {
    --primary-color: #4281A4;
    --accent-color: #48A9A6;
    --light-color: #E4DFDA;
    --warm-color: #D4B483;
    --accent-red: #C1666B;
}

/* Estilos para checkout */
.checkout-progress-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(66, 129, 164, 0.1);
    transition: all 0.3s ease;
}

.checkout-progress-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(66, 129, 164, 0.15);
}

.checkout-steps {
    display: flex;
    justify-content: space-between;
    position: relative;
    margin: 0 auto;
    max-width: 800px;
}

.checkout-steps:before {
    content: '';
    position: absolute;
    top: 20px;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--light-color), var(--accent-color));
    z-index: 1;
    border-radius: 2px;
}

.checkout-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    z-index: 2;
}

.checkout-step-number {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: var(--light-color);
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-bottom: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.checkout-step-label {
    font-size: 14px;
    color: #6c757d;
    text-align: center;
    font-weight: 500;
    transition: all 0.3s ease;
}

.checkout-step.active .checkout-step-number {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    color: white;
    transform: scale(1.1);
    box-shadow: 0 4px 15px rgba(66, 129, 164, 0.3);
}

.checkout-step.active .checkout-step-label {
    color: var(--primary-color);
    font-weight: 600;
}

.checkout-step.completed .checkout-step-number {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.checkout-step.completed .checkout-step-label {
    color: #28a745;
    font-weight: 600;
}

.checkout-summary-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(66, 129, 164, 0.1);
    transition: all 0.3s ease;
    overflow: hidden;
}

.checkout-summary-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(66, 129, 164, 0.15);
}

.checkout-summary-header {
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border-bottom: 2px solid var(--accent-color);
    padding: 1.25rem;
}

.checkout-summary-title {
    color: var(--primary-color);
    font-weight: 600;
}

.checkout-table {
    margin-bottom: 0;
}

.checkout-table-header {
    color: var(--primary-color);
    font-weight: 600;
    border-bottom: 2px solid var(--light-color);
    padding: 0.75rem 0;
}

.checkout-table-row {
    border-bottom: 1px solid rgba(66, 129, 164, 0.1);
    transition: all 0.3s ease;
}

.checkout-table-row:hover {
    background-color: rgba(66, 129, 164, 0.05);
}

.checkout-product-img {
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.checkout-product-placeholder {
    border-radius: 8px;
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
}

.checkout-product-name {
    color: var(--primary-color);
    font-weight: 600;
    font-size: 0.95rem;
}

.checkout-product-price {
    color: var(--accent-color);
    font-weight: 500;
}

.checkout-quantity {
    font-weight: 600;
    color: var(--primary-color);
    text-align: center;
}

.checkout-subtotal {
    font-weight: 600;
    color: var(--accent-color);
    text-align: end;
}

.checkout-totals {
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border-radius: 12px;
    padding: 1.5rem;
    margin-top: 1rem;
}

.checkout-total-row {
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(66, 129, 164, 0.1);
}

.checkout-total-row:last-child {
    border-bottom: none;
    padding-top: 1rem;
    border-top: 2px solid var(--accent-color);
}

.checkout-total-label {
    color: var(--primary-color);
    font-weight: 500;
}

.checkout-total-value {
    color: var(--accent-color);
}

.checkout-total-final {
    color: var(--primary-color) !important;
    font-size: 1.25rem !important;
}

/* Estilos para el mapa */
#map {
    transition: all 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(66, 129, 164, 0.1);
}

#map:hover {
    box-shadow: 0 8px 30px rgba(66, 129, 164, 0.2);
    transform: translateY(-2px);
}

/* Estilos para formularios */
.checkout-form-control {
    border-radius: 12px;
    border: 2px solid var(--light-color);
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.checkout-form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.25rem rgba(66, 129, 164, 0.25);
    transform: scale(1.02);
}

.checkout-btn {
    border-radius: 12px;
    padding: 0.875rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.checkout-btn-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    border: none;
    color: white;
}

.checkout-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(66, 129, 164, 0.3);
    background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
}

.checkout-confirm-btn {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    border: none;
    color: white;
    font-weight: 700;
    padding: 12px 24px;
    border-radius: 15px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(66, 129, 164, 0.3);
}

.checkout-confirm-btn:hover {
    background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(66, 129, 164, 0.4);
    color: white;
}

/* Toast notifications */
.toast {
    transition: all 0.3s ease;
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.toast.show {
    opacity: 1;
    transform: translateY(0);
}

.toast.hide {
    opacity: 0;
    transform: translateY(-10px);
}

/* Responsive */
@media (max-width: 768px) {
    .checkout-steps {
        max-width: 100%;
    }
    
    .checkout-step-number {
        width: 40px;
        height: 40px;
        font-size: 0.9rem;
    }
    
    .checkout-step-label {
        font-size: 12px;
    }
    
    .checkout-summary-card {
        margin-bottom: 1rem;
    }
    
    #map {
        height: 250px !important;
    }
    
    .checkout-confirm-btn {
        padding: 10px 20px;
        font-size: 0.9rem;
        border-radius: 12px;
    }
    
    .checkout-table {
        font-size: 0.9rem;
    }
    
    .checkout-product-name {
        font-size: 0.85rem;
    }
    
    .checkout-totals {
        padding: 1rem;
    }
}

@media (max-width: 576px) {
    .checkout-step-number {
        width: 35px;
        height: 35px;
        font-size: 0.8rem;
    }
    
    .checkout-step-label {
        font-size: 11px;
    }
    
    #map {
        height: 200px !important;
    }
    
    .checkout-confirm-btn {
        padding: 8px 16px;
        font-size: 0.85rem;
        border-radius: 10px;
    }
    
    .checkout-table {
        font-size: 0.8rem;
    }
    
    .checkout-product-name {
        font-size: 0.8rem;
    }
    
    .checkout-totals {
        padding: 0.75rem;
    }
}
</style>