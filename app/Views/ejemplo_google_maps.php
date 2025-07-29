<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo Google Maps</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #map {
            height: 400px;
            width: 100%;
            border-radius: 8px;
        }
        .map-container {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1>Ejemplo de Google Maps API</h1>
        
        <div class="row">
            <div class="col-md-8">
                <div class="map-container">
                    <h3>Mapa Interactivo</h3>
                    <div id="map"></div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Funciones de Google Maps</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="address" class="form-label">Dirección para geocodificar:</label>
                            <input type="text" id="address" class="form-control" placeholder="Ingresa una dirección">
                            <button onclick="geocodificar()" class="btn btn-primary mt-2">Geocodificar</button>
                        </div>
                        
                        <div class="mb-3">
                            <label for="lat" class="form-label">Latitud:</label>
                            <input type="text" id="lat" class="form-control" placeholder="Latitud">
                        </div>
                        
                        <div class="mb-3">
                            <label for="lng" class="form-label">Longitud:</label>
                            <input type="text" id="lng" class="form-control" placeholder="Longitud">
                        </div>
                        
                        <button onclick="obtenerDireccion()" class="btn btn-success">Obtener Dirección</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= google_maps_script() ?>
    <?= google_maps_init('map') ?>
    
    <script>
    let map;
    let markers = [];
    
    // Función para geocodificar una dirección
    function geocodificar() {
        const address = document.getElementById('address').value;
        if (!address) {
            alert('Por favor ingresa una dirección');
            return;
        }
        
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ address: address }, function(results, status) {
            if (status === 'OK') {
                const location = results[0].geometry.location;
                
                // Actualizar campos
                document.getElementById('lat').value = location.lat();
                document.getElementById('lng').value = location.lng();
                
                // Centrar mapa en la ubicación
                map.setCenter(location);
                map.setZoom(15);
                
                // Agregar marcador
                clearMarkers();
                addMarker(location, address);
                
                alert('Dirección geocodificada correctamente');
            } else {
                alert('Error al geocodificar la dirección: ' + status);
            }
        });
    }
    
    // Función para obtener dirección desde coordenadas
    function obtenerDireccion() {
        const lat = parseFloat(document.getElementById('lat').value);
        const lng = parseFloat(document.getElementById('lng').value);
        
        if (isNaN(lat) || isNaN(lng)) {
            alert('Por favor ingresa coordenadas válidas');
            return;
        }
        
        const geocoder = new google.maps.Geocoder();
        const latlng = { lat: lat, lng: lng };
        
        geocoder.geocode({ location: latlng }, function(results, status) {
            if (status === 'OK') {
                document.getElementById('address').value = results[0].formatted_address;
                
                // Centrar mapa en la ubicación
                map.setCenter(latlng);
                map.setZoom(15);
                
                // Agregar marcador
                clearMarkers();
                addMarker(latlng, results[0].formatted_address);
                
                alert('Dirección obtenida correctamente');
            } else {
                alert('Error al obtener la dirección: ' + status);
            }
        });
    }
    
    // Función para agregar marcador
    function addMarker(position, title) {
        const marker = new google.maps.Marker({
            position: position,
            map: map,
            title: title,
            icon: {
                url: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png'
            }
        });
        
        markers.push(marker);
        
        // Agregar info window
        const infowindow = new google.maps.InfoWindow({
            content: '<div><strong>' + title + '</strong></div>'
        });
        
        marker.addListener('click', function() {
            infowindow.open(map, marker);
        });
    }
    
    // Función para limpiar marcadores
    function clearMarkers() {
        markers.forEach(marker => marker.setMap(null));
        markers = [];
    }
    
    // Inicializar mapa cuando se carga la página
    window.addEventListener('load', function() {
        // El mapa ya se inicializa con google_maps_init()
    });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 