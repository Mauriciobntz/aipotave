<?php

/**
 * Helper para cálculos de distancia y costos de envío
 */

if (!function_exists('calcular_distancia')) {
    /**
     * Calcular distancia entre dos puntos usando la fórmula de Haversine
     */
    function calcular_distancia($lat1, $lng1, $lat2, $lng2) {
        // Radio de la Tierra en kilómetros
        $radio_tierra = 6371;
        
        // Convertir coordenadas a radianes
        $lat1_rad = deg2rad($lat1);
        $lng1_rad = deg2rad($lng1);
        $lat2_rad = deg2rad($lat2);
        $lng2_rad = deg2rad($lng2);
        
        // Diferencias en coordenadas
        $delta_lat = $lat2_rad - $lat1_rad;
        $delta_lng = $lng2_rad - $lng1_rad;
        
        // Fórmula de Haversine
        $a = sin($delta_lat / 2) * sin($delta_lat / 2) +
             cos($lat1_rad) * cos($lat2_rad) *
             sin($delta_lng / 2) * sin($delta_lng / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        // Distancia en kilómetros
        $distancia = $radio_tierra * $c;
        
        return round($distancia, 2);
    }
}

if (!function_exists('calcular_costo_envio')) {
    /**
     * Calcular costo de envío basado en la distancia usando la tabla de tarifas
     */
    function calcular_costo_envio($lat_cliente, $lng_cliente, $lat_restaurante = -25.291388888889, $lng_restaurante = -57.718333333333) {
        // Usar la base de datos directamente para obtener las tarifas
        $db = \Config\Database::connect();
        $builder = $db->table('tarifas_envio');
        $tarifas = $builder->where('activo', 1)
                          ->orderBy('orden', 'ASC')
                          ->get()
                          ->getResultArray();
        
        // Si no hay coordenadas del cliente, usar la tarifa más cara como costo por defecto
        if (empty($lat_cliente) || empty($lng_cliente)) {
            $tarifaMasCara = $builder->where('activo', 1)
                                    ->orderBy('costo', 'DESC')
                                    ->get()
                                    ->getRowArray();
            return $tarifaMasCara ? $tarifaMasCara['costo'] : 1500;
        }
        
        // Calcular distancia usando Google Maps Directions API (ruta real)
        $distancia = calcular_distancia_google_maps($lat_restaurante, $lng_restaurante, $lat_cliente, $lng_cliente);
        
        // Buscar la tarifa que corresponda a la distancia
        foreach ($tarifas as $tarifa) {
            if ($distancia >= $tarifa['distancia_minima'] && $distancia <= $tarifa['distancia_maxima']) {
                return $tarifa['costo'];
            }
        }
        
        // Si no encuentra tarifa específica, usar la más cara
        $tarifaMasCara = $builder->where('activo', 1)
                                ->orderBy('costo', 'DESC')
                                ->get()
                                ->getRowArray();
        
        return $tarifaMasCara ? $tarifaMasCara['costo'] : 1500;
    }
}

if (!function_exists('obtener_distancia_texto')) {
    /**
     * Obtener texto descriptivo de la distancia
     */
    function obtener_distancia_texto($lat_cliente, $lng_cliente, $lat_restaurante = -25.291388888889, $lng_restaurante = -57.718333333333) {
        if (empty($lat_cliente) || empty($lng_cliente)) {
            return 'Distancia no calculada';
        }
        
        $distancia = calcular_distancia($lat_restaurante, $lng_restaurante, $lat_cliente, $lng_cliente);
        
        if ($distancia < 1) {
            return number_format($distancia * 1000, 0) . ' metros';
        } else {
            return number_format($distancia, 1) . ' km';
        }
    }
}

if (!function_exists('validar_zona_entrega')) {
    /**
     * Validar si la ubicación está dentro de la zona de entrega
     */
    function validar_zona_entrega($lat_cliente, $lng_cliente, $radio_maximo = 10) {
        if (empty($lat_cliente) || empty($lng_cliente)) {
            return false;
        }
        
        $distancia = calcular_distancia(-25.291388888889, -57.718333333333, $lat_cliente, $lng_cliente);
        
        return $distancia <= $radio_maximo;
    }
}

if (!function_exists('formatear_costo_envio')) {
    /**
     * Formatear costo de envío para mostrar
     */
    function formatear_costo_envio($costo) {
        return '$' . number_format($costo, 0, ',', '.');
    }
} 

if (!function_exists('calcular_distancia_google_maps')) {
    /**
     * Calcular distancia usando Google Maps Directions API (ruta real)
     */
    function calcular_distancia_google_maps($lat_origen, $lng_origen, $lat_destino, $lng_destino) {
        $config = config('GoogleMaps');
        
        if (!$config->isConfigured()) {
            // Si no hay configuración de Google Maps, usar cálculo en línea recta
            return calcular_distancia($lat_origen, $lng_origen, $lat_destino, $lng_destino);
        }
        
        // Construir la URL para la API de Directions
        $origin = "{$lat_origen},{$lng_origen}";
        $destination = "{$lat_destino},{$lng_destino}";
        
        $url = "https://maps.googleapis.com/maps/api/directions/json?" .
               "origin=" . urlencode($origin) .
               "&destination=" . urlencode($destination) .
               "&mode=driving" .
               "&units=metric" .
               "&key=" . $config->apiKey;
        
        // Realizar la petición
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        
        if ($data && isset($data['routes'][0]['legs'][0]['distance']['value'])) {
            // Convertir metros a kilómetros
            $distancia_metros = $data['routes'][0]['legs'][0]['distance']['value'];
            return round($distancia_metros / 1000, 2);
        }
        
        // Si falla la API, usar cálculo en línea recta como respaldo
        log_message('warning', 'Google Maps Directions API falló, usando cálculo en línea recta');
        return calcular_distancia($lat_origen, $lng_origen, $lat_destino, $lng_destino);
    }
} 