<div class="container mt-5 pt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 checkout-confirmar-card">
                <div class="card-header checkout-confirmar-header">
                    <h1 class="mb-0 checkout-confirmar-title">
                        <i class="fas fa-clipboard-check me-2"></i>Paso 2 de 3: Ingresa tus datos de envío
                    </h1>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info checkout-info-alert">
                        <i class="fas fa-info-circle me-2"></i>
                        Completa tus datos para procesar tu pedido
                    </div>

                    <div class="row">
                        <!-- Resumen del carrito -->
                        <div class="col-lg-6 mb-4">
                            <h4 class="checkout-section-title">
                                <i class="fas fa-shopping-cart me-2"></i>Resumen del carrito
                            </h4>
                            <div class="table-responsive mb-4">
                                <table class="table align-middle checkout-confirmar-table">
                                    <thead>
                                        <tr>
                                            <th class="checkout-table-header">Nombre</th>
                                            <th class="checkout-table-header">Cantidad</th>
                                            <th class="checkout-table-header">Precio</th>
                                            <th class="checkout-table-header">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $total = 0; ?>
                                        <?php foreach ($carrito as $item): ?>
                                            <?php $subtotal = $item['precio'] * $item['cantidad']; $total += $subtotal; ?>
                                            <tr class="checkout-table-row">
                                                <td class="checkout-product-name"><?= esc($item['nombre']) ?></td>
                                                <td class="checkout-quantity"><?= esc($item['cantidad']) ?></td>
                                                <td class="checkout-price">$<?= number_format($item['precio'], 2) ?></td>
                                                <td class="checkout-subtotal">$<?= number_format($subtotal, 2) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="checkout-total-row">
                                            <th colspan="3" class="text-end checkout-total-label">Total:</th>
                                            <th class="checkout-total-value">$<?= number_format($total, 2) ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Formulario de datos -->
                        <div class="col-lg-6">
                            <h4 class="checkout-section-title">
                                <i class="fas fa-user me-2"></i>Datos del cliente
                            </h4>
                            <form action="<?= base_url('checkout/confirmar') ?>" method="post" class="checkout-form">
                                <!-- Campos ocultos para coordenadas -->
                                <input type="hidden" id="latitud" name="latitud" value="">
                                <input type="hidden" id="longitud" name="longitud" value="">
                                
                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <label for="nombre" class="form-label checkout-form-label">
                                            <i class="fas fa-user me-2"></i>Nombre
                                        </label>
                                        <input type="text" 
                                               class="form-control checkout-form-control" 
                                               id="nombre" 
                                               name="nombre" 
                                               placeholder="Tu nombre completo"
                                               required
                                               inputmode="text"
                                               autocomplete="name">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="celular" class="form-label checkout-form-label">
                                            <i class="fas fa-phone me-2"></i>Celular
                                        </label>
                                        <input type="text" 
                                               class="form-control checkout-form-control" 
                                               id="celular" 
                                               name="celular" 
                                               placeholder="Tu número de celular"
                                               required
                                               inputmode="tel"
                                               autocomplete="tel">
                                    </div>
                                    
                                    <!-- Sección de ubicación -->
                                    <div class="col-12">
                                        <label class="form-label checkout-form-label">
                                            <i class="fas fa-map-marker-alt me-2"></i>Dirección de entrega
                                        </label>
                                        <div class="row g-2">
                                            <div class="col-12 col-md-8">
                                                <div class="input-group">
                                                    <input type="text" 
                                                           class="form-control checkout-form-control" 
                                                           id="direccion" 
                                                           name="direccion" 
                                                           placeholder="Ingresa tu dirección o selecciónala en el mapa" 
                                                           required
                                                           inputmode="text"
                                                           autocomplete="street-address">
                                                    <span class="input-group-text" id="indicador-ubicacion" style="display: none;">
                                                        <i class="fas fa-check-circle text-success"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <button type="button" 
                                                        class="btn btn-outline-primary w-100 checkout-btn-location" 
                                                        onclick="obtenerUbicacionActual()">
                                                    <i class="fas fa-location-arrow me-2"></i>Mi Ubicación
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <label for="observaciones" class="form-label checkout-form-label">
                                            <i class="fas fa-comment me-2"></i>Observaciones
                                        </label>
                                        <textarea class="form-control checkout-form-control" 
                                                  id="observaciones" 
                                                  name="observaciones" 
                                                  rows="3" 
                                                  placeholder="Ej: sin mayonesa, llamar al llegar..."></textarea>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="metodo_pago" class="form-label checkout-form-label">
                                            <i class="fas fa-credit-card me-2"></i>Forma de pago
                                        </label>
                                        <select class="form-select checkout-form-control" 
                                                id="metodo_pago" 
                                                name="metodo_pago" 
                                                required>
                                            <option value="">Selecciona una opción</option>
                                            <option value="efectivo">Efectivo</option>
                                            <option value="tarjeta">Tarjeta</option>
                                            <option value="transferencia">Transferencia</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <div class="d-flex flex-column flex-md-row gap-3">
                                            <button type="submit" class="btn btn-success checkout-btn-confirm">
                                                <i class="fas fa-check me-2"></i>Confirmar Pedido
                                            </button>
                                            <a href="<?= base_url('carrito') ?>" class="btn btn-outline-secondary checkout-btn-back">
                                                <i class="fas fa-arrow-left me-2"></i>Volver al carrito
                                            </a>
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

<!-- Incluir Leaflet para el mapa -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
/* Variables de color para consistencia */
:root {
    --primary-color: #4281A4;
    --accent-color: #48A9A6;
    --light-color: #E4DFDA;
    --warm-color: #D4B483;
    --accent-red: #C1666B;
}

/* Estilos para checkout confirmar */
.checkout-confirmar-card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(66, 129, 164, 0.15);
    transition: all 0.3s ease;
    overflow: hidden;
}

.checkout-confirmar-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(66, 129, 164, 0.2);
}

.checkout-confirmar-header {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    color: white;
    border-radius: 20px 20px 0 0 !important;
    border: none;
    padding: 1.5rem;
}

.checkout-confirmar-title {
    font-weight: 600;
    margin-bottom: 0;
    font-size: 1.5rem;
}

.checkout-info-alert {
    border-radius: 12px;
    border: none;
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border-left: 4px solid var(--accent-color);
    color: var(--primary-color);
    padding: 1rem;
    margin-bottom: 2rem;
}

.checkout-section-title {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 1.5rem;
    font-size: 1.25rem;
}

.checkout-confirmar-table {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.checkout-table-header {
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    color: var(--primary-color);
    font-weight: 600;
    border-bottom: 2px solid var(--accent-color);
    padding: 1rem 0.75rem;
}

.checkout-table-row {
    border-bottom: 1px solid rgba(66, 129, 164, 0.1);
    transition: all 0.3s ease;
}

.checkout-table-row:hover {
    background-color: rgba(66, 129, 164, 0.05);
}

.checkout-product-name {
    color: var(--primary-color);
    font-weight: 600;
    font-size: 0.95rem;
}

.checkout-quantity {
    font-weight: 600;
    color: var(--accent-color);
    text-align: center;
}

.checkout-price {
    color: var(--warm-color);
    font-weight: 500;
}

.checkout-subtotal {
    font-weight: 600;
    color: var(--accent-color);
    text-align: end;
}

.checkout-total-row {
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border-top: 2px solid var(--accent-color);
}

.checkout-total-label {
    color: var(--primary-color);
    font-weight: 600;
}

.checkout-total-value {
    color: var(--primary-color);
    font-weight: 600;
    font-size: 1.1rem;
}

.checkout-form-label {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}

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

.checkout-btn-location {
    border-radius: 12px;
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    font-weight: 600;
    transition: all 0.3s ease;
}

.checkout-btn-location:hover {
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(66, 129, 164, 0.3);
}

.checkout-btn-confirm {
    border-radius: 12px;
    padding: 0.875rem 2rem;
    font-weight: 600;
    background: linear-gradient(135deg, #28a745, #20c997);
    border: none;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.checkout-btn-confirm:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
    background: linear-gradient(135deg, #20c997, #28a745);
}

.checkout-btn-back {
    border-radius: 12px;
    padding: 0.875rem 2rem;
    font-weight: 600;
    border: 2px solid var(--light-color);
    color: var(--primary-color);
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.checkout-btn-back:hover {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(66, 129, 164, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .checkout-confirmar-card {
        margin: 0.5rem;
        border-radius: 15px;
    }
    
    .checkout-confirmar-header {
        padding: 1rem;
        border-radius: 15px 15px 0 0 !important;
    }
    
    .checkout-confirmar-title {
        font-size: 1.3rem;
    }
    
    .checkout-form-control {
        font-size: 0.95rem;
        padding: 0.6rem 0.875rem;
        border-radius: 10px;
    }
    
    .checkout-btn-confirm,
    .checkout-btn-back {
        padding: 0.75rem 1.5rem;
        font-size: 0.9rem;
        border-radius: 10px;
    }
    
    .checkout-table {
        font-size: 0.9rem;
    }
    
    .checkout-product-name {
        font-size: 0.85rem;
    }
    
    .checkout-section-title {
        font-size: 1.1rem;
    }
    
    .checkout-info-alert {
        padding: 0.75rem;
        border-radius: 10px;
    }
}

@media (max-width: 576px) {
    .checkout-confirmar-card {
        margin: 0.25rem;
        border-radius: 12px;
    }
    
    .checkout-confirmar-header {
        padding: 0.75rem;
        border-radius: 12px 12px 0 0 !important;
    }
    
    .checkout-confirmar-title {
        font-size: 1.1rem;
    }
    
    .checkout-form-control {
        font-size: 0.9rem;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
    }
    
    .checkout-btn-confirm,
    .checkout-btn-back {
        padding: 0.6rem 1.2rem;
        font-size: 0.85rem;
        border-radius: 8px;
    }
    
    .checkout-table {
        font-size: 0.8rem;
    }
    
    .checkout-product-name {
        font-size: 0.8rem;
    }
    
    .checkout-section-title {
        font-size: 1rem;
    }
    
    .checkout-info-alert {
        padding: 0.6rem;
        border-radius: 8px;
    }
}
</style>

<script>
let map;
let marker;
let ubicacionSeleccionada = null;

// Inicializar mapa cuando la página carga
document.addEventListener('DOMContentLoaded', function() {
    // Centrar en Clorinda, Formosa
    map = L.map('map').setView([-25.291388888889, -57.718333333333], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    // Manejar clics en el mapa
    map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        
        // Actualizar marcador
        if (marker) {
            map.removeLayer(marker);
        }
        marker = L.marker([lat, lng]).addTo(map);
        
        // Actualizar campos ocultos
        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lng;
        
        // Obtener dirección usando geocodificación inversa
        obtenerDireccionDesdeCoordenadas(lat, lng);
        
        ubicacionSeleccionada = { lat: lat, lng: lng };
    });
});

// Función para obtener ubicación actual del usuario
function obtenerUbicacionActual() {
    if (navigator.geolocation) {
        // Mostrar indicador de carga
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Obteniendo ubicación...';
        btn.disabled = true;
        
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                // Centrar mapa en la ubicación actual
                map.setView([lat, lng], 16);
                
                // Agregar marcador
                if (marker) {
                    map.removeLayer(marker);
                }
                marker = L.marker([lat, lng]).addTo(map);
                
                // Obtener dirección
                obtenerDireccionDesdeCoordenadas(lat, lng);
                
                // Actualizar campos ocultos
                document.getElementById('latitud').value = lat;
                document.getElementById('longitud').value = lng;
                
                ubicacionSeleccionada = { lat: lat, lng: lng };
                
                // Restaurar botón
                btn.innerHTML = originalText;
                btn.disabled = false;
                
                // Mostrar mensaje de éxito
                mostrarMensaje('Ubicación obtenida correctamente', 'success');
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
                mostrarMensaje(mensaje, 'danger');
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 300000 // 5 minutos
            }
        );
    } else {
        mostrarMensaje('La geolocalización no está disponible en tu navegador', 'warning');
    }
}

// Función para mostrar indicador de ubicación seleccionada
function mostrarIndicadorUbicacion() {
    const indicador = document.getElementById('indicador-ubicacion');
    indicador.style.display = 'block';
    indicador.title = 'Ubicación seleccionada en el mapa';
}

// Función para ocultar indicador de ubicación
function ocultarIndicadorUbicacion() {
    const indicador = document.getElementById('indicador-ubicacion');
    indicador.style.display = 'none';
}

// Función para obtener dirección desde coordenadas
function obtenerDireccionDesdeCoordenadas(lat, lng) {
    // Usar Nominatim (OpenStreetMap) para geocodificación inversa
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
        .then(response => response.json())
        .then(data => {
            if (data.display_name) {
                document.getElementById('direccion').value = data.display_name;
                mostrarMensaje('Dirección obtenida automáticamente', 'success');
                mostrarIndicadorUbicacion();
            }
        })
        .catch(error => {
            console.error('Error al obtener dirección:', error);
            // Si falla la geocodificación, usar coordenadas
            document.getElementById('direccion').value = `${lat}, ${lng}`;
            mostrarIndicadorUbicacion();
        });
}

// Función para limpiar ubicación seleccionada
function limpiarUbicacion() {
    if (marker) {
        map.removeLayer(marker);
        marker = null;
    }
    document.getElementById('direccion').value = '';
    document.getElementById('latitud').value = '';
    document.getElementById('longitud').value = '';
    ocultarIndicadorUbicacion(); // Ocultar indicador al limpiar
    ubicacionSeleccionada = null;
    mostrarMensaje('Ubicación limpiada', 'info');
}

// Función para mostrar mensajes
function mostrarMensaje(mensaje, tipo) {
    // Crear o actualizar alerta
    let alerta = document.getElementById('alerta-ubicacion');
    if (!alerta) {
        alerta = document.createElement('div');
        alerta.id = 'alerta-ubicacion';
        alerta.className = 'alert alert-' + tipo + ' alert-dismissible fade show';
        alerta.innerHTML = `
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.querySelector('.container').insertBefore(alerta, document.querySelector('h4'));
    } else {
        alerta.className = 'alert alert-' + tipo + ' alert-dismissible fade show';
        alerta.innerHTML = `
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
    }
    
    // Auto-ocultar después de 5 segundos
    setTimeout(() => {
        if (alerta && alerta.parentNode) {
            alerta.remove();
        }
    }, 5000);
}

// Validar que se haya seleccionado una ubicación antes de enviar
document.querySelector('form').addEventListener('submit', function(e) {
    const direccion = document.getElementById('direccion').value.trim();
    const latitud = document.getElementById('latitud').value;
    const longitud = document.getElementById('longitud').value;
    
    if (!direccion) {
        e.preventDefault();
        mostrarMensaje('Por favor, ingresa tu dirección de entrega', 'warning');
        return false;
    }
    
    // Si no hay coordenadas pero sí dirección, mostrar advertencia
    if (!latitud || !longitud) {
        const confirmar = confirm('No has seleccionado una ubicación exacta en el mapa. ¿Deseas continuar con solo la dirección escrita?');
        if (!confirmar) {
            e.preventDefault();
            return false;
        }
        mostrarMensaje('Se recomienda seleccionar tu ubicación exacta en el mapa para una mejor entrega', 'info');
    } else {
        mostrarMensaje('Ubicación exacta seleccionada. ¡Perfecto para la entrega!', 'success');
    }
});
</script> 