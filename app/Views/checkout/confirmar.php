<div class="container">
    <h1 class="mb-4">Confirmar Pedido</h1>
    
    <div class="alert alert-info">
        <strong>Debug:</strong> Esta es la vista de checkout/confirmar.php
    </div>

    <h4>Resumen del carrito</h4>
    <div class="table-responsive mb-4">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($carrito as $item): ?>
                    <?php $subtotal = $item['precio'] * $item['cantidad']; $total += $subtotal; ?>
                    <tr>
                        <td><?= esc($item['nombre']) ?></td>
                        <td><?= esc($item['cantidad']) ?></td>
                        <td>$<?= number_format($item['precio'], 2) ?></td>
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

    <h4>Datos del cliente</h4>
    <form action="<?= base_url('checkout/confirmar') ?>" method="post" class="row g-3">
        <!-- Campos ocultos para coordenadas -->
        <input type="hidden" id="latitud" name="latitud" value="">
        <input type="hidden" id="longitud" name="longitud" value="">
        
        <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="col-md-6">
            <label for="celular" class="form-label">Celular</label>
            <input type="text" class="form-control" id="celular" name="celular" required>
        </div>
        
        <!-- Sección de ubicación -->
        <div class="col-12">
            <label class="form-label">Dirección de entrega</label>
            <div class="row g-2">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ingresa tu dirección o selecciónala en el mapa" required>
                        <span class="input-group-text" id="indicador-ubicacion" style="display: none;">
                            <i class="fas fa-check-circle text-success"></i>
                        </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-outline-primary w-100" onclick="obtenerUbicacionActual()">
                        <i class="fas fa-location-arrow me-2"></i>Mi Ubicación
                    </button>
                </div>
            </div>
        </div>
        
        <div class="col-12">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones" rows="2" placeholder="Ej: sin mayonesa, llamar al llegar..."></textarea>
        </div>
        <div class="col-md-6">
            <label for="metodo_pago" class="form-label">Forma de pago (externo)</label>
            <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                <option value="">Selecciona una opción</option>
                <option value="efectivo">Efectivo</option>
                <option value="tarjeta">Tarjeta</option>
                <option value="transferencia">Transferencia</option>
            </select>
        </div>
        <div class="col-12 mt-4">
            <button type="submit" class="btn btn-success">Confirmar Pedido</button>
            <a href="<?= base_url('carrito') ?>" class="btn btn-secondary ms-2">Volver al carrito</a>
        </div>
    </form>
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
    // Centrar en una ubicación por defecto (puedes ajustar las coordenadas)
    map = L.map('map').setView([-34.6, -58.4], 13);
    
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