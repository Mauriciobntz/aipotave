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
     * Calcular costo de envío basado en la distancia
     */
    function calcular_costo_envio($lat_cliente, $lng_cliente, $lat_restaurante = -25.291388888889, $lng_restaurante = -57.718333333333) {
        // Si no hay coordenadas del cliente, usar costo por defecto
        if (empty($lat_cliente) || empty($lng_cliente)) {
            return 1500; // Costo por defecto para casos sin coordenadas
        }
        
        // Calcular distancia
        $distancia = calcular_distancia($lat_restaurante, $lng_restaurante, $lat_cliente, $lng_cliente);
        
        // Aplicar tarifas según distancia
        if ($distancia <= 1.5) {
            return 1000; // Hasta 1.5 km: $1,000
        } else {
            return 1500; // Más de 1.5 km: $1,500
        }
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