// Web Worker para monitoreo de ubicación
// Funciona mejor en móviles que Service Workers

let watchId = null;
let isActive = false;
let lastLocation = null;

// Función para calcular distancia
function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371; // Radio de la Tierra en km
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
              Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
              Math.sin(dLon/2) * Math.sin(dLon/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c * 1000; // Distancia en metros
}

// Función para verificar si el cambio es significativo
function isSignificantChange(newLat, newLon) {
    if (!lastLocation) return true;
    
    const distance = calculateDistance(
        lastLocation.lat,
        lastLocation.lon,
        newLat,
        newLon
    );
    
    return distance > 50; // 50 metros
}

// Función para enviar ubicación al servidor
async function sendLocationToServer(lat, lng, pedidoId) {
    try {
        const response = await fetch('/max/repartidor/actualizar-ubicacion', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                pedido_id: pedidoId,
                latitud: lat,
                longitud: lng
            })
        });
        
        const data = await response.json();
        return data.success;
    } catch (error) {
        console.error('Error al enviar ubicación:', error);
        return false;
    }
}

// Función de éxito para geolocalización
function onLocationSuccess(position) {
    const lat = position.coords.latitude;
    const lng = position.coords.longitude;
    
    // Notificar al hilo principal
    self.postMessage({
        type: 'LOCATION_UPDATE',
        lat: lat,
        lng: lng,
        accuracy: position.coords.accuracy,
        timestamp: new Date().toISOString()
    });
    
    // Verificar si hay cambio significativo
    if (isSignificantChange(lat, lng)) {
        lastLocation = { lat: lat, lon: lng };
        
        // Enviar al servidor si hay pedido activo
        if (isActive && self.pedidoActivo) {
            sendLocationToServer(lat, lng, self.pedidoActivo).then(success => {
                self.postMessage({
                    type: 'SERVER_UPDATE',
                    success: success,
                    timestamp: new Date().toISOString()
                });
            });
        }
    }
}

// Función de error para geolocalización
function onLocationError(error) {
    let errorMessage = 'Error de geolocalización';
    switch(error.code) {
        case error.PERMISSION_DENIED:
            errorMessage = 'Permiso de ubicación denegado';
            break;
        case error.POSITION_UNAVAILABLE:
            errorMessage = 'Ubicación no disponible';
            break;
        case error.TIMEOUT:
            errorMessage = 'Timeout al obtener ubicación';
            break;
        default:
            errorMessage = error.message || 'Error desconocido';
    }
    
    self.postMessage({
        type: 'LOCATION_ERROR',
        error: errorMessage,
        code: error.code
    });
}

// Configuración de geolocalización
const geoOptions = {
    enableHighAccuracy: true,
    timeout: 30000,
    maximumAge: 60000
};

// Escuchar mensajes del hilo principal
self.addEventListener('message', function(event) {
    console.log('Web Worker recibió mensaje:', event.data);
    
    switch(event.data.type) {
        case 'START_MONITORING':
            if (!isActive) {
                isActive = true;
                self.pedidoActivo = event.data.pedidoId;
                
                // Obtener ubicación inicial
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        onLocationSuccess,
                        onLocationError,
                        geoOptions
                    );
                    
                    // Iniciar monitoreo continuo
                    watchId = navigator.geolocation.watchPosition(
                        onLocationSuccess,
                        onLocationError,
                        geoOptions
                    );
                    
                    self.postMessage({
                        type: 'MONITORING_STARTED',
                        pedidoId: self.pedidoActivo
                    });
                } else {
                    self.postMessage({
                        type: 'ERROR',
                        error: 'Geolocalización no soportada'
                    });
                }
            }
            break;
            
        case 'STOP_MONITORING':
            if (isActive) {
                isActive = false;
                self.pedidoActivo = null;
                
                if (watchId) {
                    navigator.geolocation.clearWatch(watchId);
                    watchId = null;
                }
                
                self.postMessage({
                    type: 'MONITORING_STOPPED'
                });
            }
            break;
            
        case 'GET_STATUS':
            self.postMessage({
                type: 'STATUS',
                isActive: isActive,
                pedidoActivo: self.pedidoActivo,
                lastLocation: lastLocation
            });
            break;
    }
});

console.log('Web Worker de ubicación cargado'); 