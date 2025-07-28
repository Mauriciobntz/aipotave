// Service Worker para actualización de ubicación en segundo plano
const CACHE_NAME = 'repartidor-v1';
const urlsToCache = [
    '/',
    '/css/bootstrap.min.css',
    '/js/bootstrap.bundle.min.js'
];

// Instalación del Service Worker
self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(function(cache) {
                return cache.addAll(urlsToCache);
            })
    );
});

// Activación del Service Worker
self.addEventListener('activate', function(event) {
    event.waitUntil(
        caches.keys().then(function(cacheNames) {
            return Promise.all(
                cacheNames.map(function(cacheName) {
                    if (cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});

// Interceptar peticiones de red
self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request)
            .then(function(response) {
                // Devolver desde cache si está disponible
                if (response) {
                    return response;
                }
                
                // Si no está en cache, hacer petición a red
                return fetch(event.request).then(function(response) {
                    // No cachear peticiones de ubicación
                    if (event.request.url.includes('actualizar-ubicacion')) {
                        return response;
                    }
                    
                    // Cachear otras peticiones
                    if (response.status === 200) {
                        const responseClone = response.clone();
                        caches.open(CACHE_NAME).then(function(cache) {
                            cache.put(event.request, responseClone);
                        });
                    }
                    
                    return response;
                });
            })
    );
});

// Manejar mensajes del cliente
self.addEventListener('message', function(event) {
    if (event.data && event.data.type === 'location_update') {
        // Enviar ubicación al servidor
        fetch('/repartidor/actualizar-ubicacion', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                pedido_id: event.data.pedido_id,
                latitud: event.data.latitud,
                longitud: event.data.longitud
            })
        }).then(response => {
            if (response.ok) {
                // Ubicación actualizada correctamente
            }
        }).catch(error => {
            // Error al actualizar ubicación
        });
    }
});

// Sincronización en segundo plano
self.addEventListener('sync', function(event) {
    if (event.tag === 'location-sync') {
        // Sincronizar ubicación cuando hay conexión
    }
}); 