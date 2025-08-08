

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>Configurar Punto de Partida
                    </h4>
                </div>
                <div class="card-body">
                    <?php if (session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?= esc(session('success')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i><?= esc(session('error')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Importante:</strong> Esta configuración se utiliza para calcular las distancias de envío y centrar el mapa en el checkout. 
                        Asegúrate de que las coordenadas sean precisas.
                    </div>

                    <form action="<?= base_url('admin/configuracion/actualizar-punto-partida') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="nombre" class="form-label">
                                    <i class="fas fa-store me-1"></i>Nombre del Restaurante
                                </label>
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                       value="<?= esc($puntoPartida['nombre']) ?>" required>
                                <div class="form-text">Nombre que aparecerá en el mapa y en los cálculos de distancia.</div>
                            </div>

                            <div class="col-12">
                                <label for="direccion" class="form-label">
                                    <i class="fas fa-map me-1"></i>Dirección Completa
                                </label>
                                <input type="text" class="form-control" id="direccion" name="direccion" 
                                       value="<?= esc($puntoPartida['direccion']) ?>" required>
                                <div class="form-text">Dirección completa del restaurante (ej: Av. Principal 123, Clorinda, Formosa).</div>
                            </div>

                            <div class="col-md-6">
                                <label for="latitud" class="form-label">
                                    <i class="fas fa-globe me-1"></i>Latitud
                                </label>
                                <input type="number" class="form-control" id="latitud" name="latitud" 
                                       value="<?= esc($puntoPartida['latitud']) ?>" 
                                       step="0.000001" 
                                       min="-55" max="-22"
                                       placeholder="-25.281726"
                                       required>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Coordenada de latitud para Argentina (-55 a -22). Se redondea a 6 decimales.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="longitud" class="form-label">
                                    <i class="fas fa-globe me-1"></i>Longitud
                                </label>
                                <input type="number" class="form-control" id="longitud" name="longitud" 
                                       value="<?= esc($puntoPartida['longitud']) ?>" 
                                       step="0.000001" 
                                       min="-73" max="-54"
                                       placeholder="-57.729468"
                                       required>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Coordenada de longitud para Argentina (-73 a -54). Se redondea a 6 decimales.
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            <i class="fas fa-map-marked-alt me-2"></i>Vista Previa del Mapa
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div id="map" style="height: 300px; width: 100%; border-radius: 8px;"></div>
                                        <small class="text-muted">Haz clic en el mapa para actualizar las coordenadas automáticamente.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="<?= base_url('admin/configuracion') ?>" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Volver
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Guardar Cambios
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

<!-- Incluir Google Maps -->
<?= google_maps_script('places,geocoding') ?>

<script>
let map;
let marker;
let geocoder;

function initMap() {
    // Obtener coordenadas actuales
    const lat = parseFloat(document.getElementById('latitud').value);
    const lng = parseFloat(document.getElementById('longitud').value);
    
    map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: lat, lng: lng },
        zoom: 15,
        mapTypeControl: false,
        streetViewControl: false,
        fullscreenControl: true
    });

    // Agregar marcador inicial
    marker = new google.maps.Marker({
        position: { lat: lat, lng: lng },
        map: map,
        title: 'Punto de Partida',
        draggable: true
    });

    geocoder = new google.maps.Geocoder();

    // Manejar clics en el mapa
    map.addListener('click', function(e) {
        const newLat = redondearCoordenada(e.latLng.lat());
        const newLng = redondearCoordenada(e.latLng.lng());
        
        // Actualizar marcador
        marker.setPosition({ lat: newLat, lng: newLng });
        
        // Actualizar campos
        document.getElementById('latitud').value = newLat;
        document.getElementById('longitud').value = newLng;
        
        // Obtener dirección
        obtenerDireccion(newLat, newLng);
    });

    // Manejar arrastre del marcador
    marker.addListener('dragend', function(e) {
        const newLat = redondearCoordenada(e.latLng.lat());
        const newLng = redondearCoordenada(e.latLng.lng());
        
        // Actualizar campos
        document.getElementById('latitud').value = newLat;
        document.getElementById('longitud').value = newLng;
        
        // Obtener dirección
        obtenerDireccion(newLat, newLng);
    });
}

function obtenerDireccion(lat, lng) {
    geocoder.geocode({ location: { lat: lat, lng: lng } }, function(results, status) {
        if (status === 'OK' && results[0]) {
            document.getElementById('direccion').value = results[0].formatted_address;
        }
    });
}

// Función para redondear coordenadas a 6 decimales
function redondearCoordenada(valor) {
    return Math.round(parseFloat(valor) * 1000000) / 1000000;
}

// Validación y formateo de coordenadas
function validarYFormatearCoordenadas() {
    const latInput = document.getElementById('latitud');
    const lngInput = document.getElementById('longitud');
    
    // Redondear latitud
    if (latInput.value) {
        const lat = redondearCoordenada(latInput.value);
        if (lat >= -55 && lat <= -22) {
            latInput.value = lat;
        }
    }
    
    // Redondear longitud
    if (lngInput.value) {
        const lng = redondearCoordenada(lngInput.value);
        if (lng >= -73 && lng <= -54) {
            lngInput.value = lng;
        }
    }
}

// Validar antes de enviar el formulario
document.querySelector('form').addEventListener('submit', function(e) {
    const lat = parseFloat(document.getElementById('latitud').value);
    const lng = parseFloat(document.getElementById('longitud').value);
    
    if (isNaN(lat) || lat < -55 || lat > -22) {
        e.preventDefault();
        alert('La latitud debe estar en el rango de Argentina (-55 a -22)');
        return false;
    }
    
    if (isNaN(lng) || lng < -73 || lng > -54) {
        e.preventDefault();
        alert('La longitud debe estar en el rango de Argentina (-73 a -54)');
        return false;
    }
});

// Formatear coordenadas al cambiar
document.getElementById('latitud').addEventListener('blur', function() {
    if (this.value) {
        const lat = redondearCoordenada(this.value);
        if (lat >= -55 && lat <= -22) {
            this.value = lat;
        }
    }
});

document.getElementById('longitud').addEventListener('blur', function() {
    if (this.value) {
        const lng = redondearCoordenada(this.value);
        if (lng >= -73 && lng <= -54) {
            this.value = lng;
        }
    }
});

// Inicializar mapa cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    if (typeof google !== 'undefined' && google.maps) {
        initMap();
    } else {
        window.addEventListener('load', function() {
            if (typeof google !== 'undefined' && google.maps) {
                initMap();
            }
        });
    }
});
</script>

<style>
.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(66, 129, 164, 0.1);
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
    border-bottom: none;
}

#map {
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

#map:hover {
    border-color: #4281A4;
    box-shadow: 0 4px 15px rgba(66, 129, 164, 0.2);
}

.form-control:focus {
    border-color: #4281A4;
    box-shadow: 0 0 0 0.25rem rgba(66, 129, 164, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #4281A4, #48A9A6);
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #48A9A6, #4281A4);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(66, 129, 164, 0.3);
}
</style>


