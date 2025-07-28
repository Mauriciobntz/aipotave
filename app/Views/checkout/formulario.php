<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Resumen del carrito -->
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-shopping-cart me-2"></i>Resumen del Pedido
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($carrito as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if (!empty($item['imagen'])): ?>
                                            <img src="<?= base_url('public/' . $item['imagen']) ?>" 
                                                 alt="<?= esc($item['nombre']) ?>" 
                                                 class="product-img me-3">
                                            <?php endif; ?>
                                            <div>
                                                <strong><?= esc($item['nombre']) ?></strong>
                                                <?php if (!empty($item['observaciones'])): ?>
                                                <br><small class="text-muted"><?= esc($item['observaciones']) ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= esc($item['cantidad']) ?></td>
                                    <td>$<?= number_format($item['precio'], 2) ?></td>
                                    <td>$<?= number_format($item['precio'] * $item['cantidad'], 2) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Subtotal:</th>
                                    <th>$<?= number_format($subtotal, 2) ?></th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-end">Envío:</th>
                                    <th>$<?= number_format($envio, 2) ?></th>
                                </tr>
                                <tr class="table-success">
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th>$<?= number_format($total, 2) ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Formulario de datos del cliente -->
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user me-2"></i>Datos de Entrega
                    </h4>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('checkout/procesar') ?>" method="post" class="row g-3">
                        <!-- Campos ocultos para coordenadas -->
                        <input type="hidden" id="latitud" name="latitud" value="">
                        <input type="hidden" id="longitud" name="longitud" value="">
                        
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre completo *</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required minlength="3" value="">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" value="" placeholder="opcional">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="celular" class="form-label">Celular *</label>
                            <input type="tel" class="form-control" id="celular" name="celular" required minlength="6" placeholder="Ej: 11-1234-5678">
                        </div>
                        
                        <div class="col-12">
                            <label for="direccion" class="form-label">Dirección de entrega *</label>
                            <textarea class="form-control" id="direccion" name="direccion" rows="2" required minlength="5" placeholder="Ingresa tu dirección completa en Clorinda"></textarea>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="entre" class="form-label">Entre calles</label>
                            <input type="text" class="form-control" id="entre" name="entre" value="" placeholder="Ej: Av. San Martín y Calle 25 de Mayo">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="indicacion" class="form-label">Indicaciones adicionales</label>
                            <input type="text" class="form-control" id="indicacion" name="indicacion" value="" placeholder="Ej: Casa azul, 2do piso">
                        </div>
                        
                        <!-- Mapa interactivo -->
                        <div class="col-12">
                            <label class="form-label">
                                <i class="fas fa-map-marker-alt me-2"></i>Selecciona tu ubicación en el mapa
                            </label>
                            <div class="d-flex gap-2 mb-2">
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="obtenerUbicacionActual()">
                                    <i class="fas fa-location-arrow me-1"></i>Usar mi ubicación actual
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="limpiarUbicacion()">
                                    <i class="fas fa-times me-1"></i>Limpiar ubicación
                                </button>
                            </div>
                            <div id="map" style="height: 400px; width: 100%; border-radius: 8px; border: 2px solid #dee2e6;"></div>
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Haz clic en el mapa para seleccionar tu ubicación exacta en Clorinda o usa el botón para obtener tu ubicación actual
                            </small>
                        </div>
                        
                        <div class="col-12">
                            <label for="observaciones" class="form-label">Observaciones del pedido</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Ej: sin mayonesa, llamar al llegar, instrucciones especiales..."></textarea>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="metodo_pago" class="form-label">Forma de pago *</label>
                            <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                                <option value="">Selecciona una opción</option>
                                <option value="efectivo">Efectivo</option>
                                <option value="tarjeta">Tarjeta</option>
                                <option value="transferencia">Transferencia</option>
                            </select>
                            <small class="text-muted">El pago se realizará al recibir el pedido o por WhatsApp</small>
                        </div>
                        
                        <div class="col-12 mt-4">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-check me-2"></i>Confirmar Pedido
                                </button>
                                <a href="<?= base_url('carrito') ?>" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i>Volver al carrito
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluir Leaflet para el mapa -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
let map;
let marker;
let ubicacionSeleccionada = null;

// Inicializar mapa cuando la página carga
document.addEventListener('DOMContentLoaded', function() {
    // Centrar en Clorinda, Formosa, Argentina
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
                
                // Actualizar campos ocultos
                document.getElementById('latitud').value = lat;
                document.getElementById('longitud').value = lng;
                
                // Obtener dirección usando geocodificación inversa
                obtenerDireccionDesdeCoordenadas(lat, lng);
                
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

// Función para obtener dirección desde coordenadas
function obtenerDireccionDesdeCoordenadas(lat, lng) {
    // Usar Nominatim (OpenStreetMap) para geocodificación inversa
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
        .then(response => response.json())
        .then(data => {
            if (data.display_name) {
                document.getElementById('direccion').value = data.display_name;
                mostrarMensaje('Dirección obtenida automáticamente', 'success');
            }
        })
        .catch(error => {
            console.error('Error al obtener dirección:', error);
            // Si falla la geocodificación, usar coordenadas
            document.getElementById('direccion').value = `${lat}, ${lng}`;
        });
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
        document.querySelector('.container').insertBefore(alerta, document.querySelector('.card'));
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

// Función para limpiar ubicación seleccionada
function limpiarUbicacion() {
    if (marker) {
        map.removeLayer(marker);
        marker = null;
    }
    document.getElementById('direccion').value = '';
    document.getElementById('latitud').value = '';
    document.getElementById('longitud').value = '';
    ubicacionSeleccionada = null;
    mostrarMensaje('Ubicación limpiada', 'info');
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