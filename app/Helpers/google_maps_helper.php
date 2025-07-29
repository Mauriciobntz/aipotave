<?php

/**
 * Google Maps Helper
 * 
 * Funciones auxiliares para trabajar con Google Maps API
 */

if (!function_exists('google_maps_script')) {
    /**
     * Genera el script de Google Maps con la API key configurada
     */
    function google_maps_script($libraries = 'places,geometry'): string
    {
        $config = config('GoogleMaps');
        
        if (!$config->isConfigured()) {
            log_message('warning', 'Google Maps API key no está configurada');
            return '';
        }
        
        $apiKey = $config->apiKey;
        return "<script src=\"https://maps.googleapis.com/maps/api/js?key={$apiKey}&libraries={$libraries}&loading=async\" async defer></script>";
    }
}

if (!function_exists('google_maps_script_directions')) {
    /**
     * Genera el script de Google Maps con librerías específicas para direcciones
     */
    function google_maps_script_directions(): string
    {
        $config = config('GoogleMaps');
        
        if (!$config->isConfigured()) {
            log_message('warning', 'Google Maps API key no está configurada');
            return '';
        }
        
        $apiKey = $config->apiKey;
        return "<script src=\"https://maps.googleapis.com/maps/api/js?key={$apiKey}&libraries=places,geometry&loading=async&callback=initMap\" async defer></script>";
    }
}

if (!function_exists('google_maps_init')) {
    /**
     * Genera el código JavaScript para inicializar Google Maps
     */
    function google_maps_init($elementId = 'map', $lat = -25.291388888889, $lng = -57.718333333333, $zoom = 13): string
    {
        $config = config('GoogleMaps');
        
        if (!$config->isConfigured()) {
            return '';
        }
        
        return "
        <script>
        function initMap() {
            const map = new google.maps.Map(document.getElementById('{$elementId}'), {
                center: { lat: {$lat}, lng: {$lng} },
                zoom: {$zoom}
            });
            
            // Marcador del restaurante
            const restaurantMarker = new google.maps.Marker({
                position: { lat: {$lat}, lng: {$lng} },
                map: map,
                title: 'Restaurante',
                icon: {
                    url: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png'
                }
            });
            
            return map;
        }
        </script>";
    }
}

if (!function_exists('google_maps_geocode')) {
    /**
     * Realiza geocodificación usando Google Maps API
     */
    function google_maps_geocode($address): ?array
    {
        $config = config('GoogleMaps');
        
        if (!$config->isConfigured()) {
            return null;
        }
        
        $url = $config->getGeocodingUrl() . '&address=' . urlencode($address);
        
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        
        if ($data && isset($data['results'][0]['geometry']['location'])) {
            return $data['results'][0]['geometry']['location'];
        }
        
        return null;
    }
}

if (!function_exists('google_maps_reverse_geocode')) {
    /**
     * Realiza geocodificación inversa usando Google Maps API
     */
    function google_maps_reverse_geocode($lat, $lng): ?string
    {
        $config = config('GoogleMaps');
        
        if (!$config->isConfigured()) {
            return null;
        }
        
        $url = $config->getGeocodingUrl() . "&latlng={$lat},{$lng}";
        
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        
        if ($data && isset($data['results'][0]['formatted_address'])) {
            return $data['results'][0]['formatted_address'];
        }
        
        return null;
    }
}

if (!function_exists('google_maps_directions')) {
    /**
     * Obtiene direcciones entre dos puntos usando Google Maps API
     */
    function google_maps_directions($origin, $destination): ?array
    {
        $config = config('GoogleMaps');
        
        if (!$config->isConfigured()) {
            return null;
        }
        
        $url = $config->getDirectionsUrl() . "&origin=" . urlencode($origin) . "&destination=" . urlencode($destination);
        
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        
        if ($data && isset($data['routes'][0])) {
            return $data['routes'][0];
        }
        
        return null;
    }
} 