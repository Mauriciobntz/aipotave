<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class GoogleMaps extends BaseConfig
{
    /**
     * Google Maps API Key
     * 
     * Obtiene la API key desde variables de entorno o usa un valor por defecto
     */
    public string $apiKey = '';

    /**
     * Constructor para cargar la API key desde variables de entorno
     */
    public function __construct()
    {
        parent::__construct();
        
        // Intentar obtener la API key desde variables de entorno
        $this->apiKey = env('GOOGLE_MAPS_API_KEY', 'AIzaSyBCnIKlDT5Ejj-Uoj1cL0nw2aHEaQOFrAs');
    }

    /**
     * Verifica si la API key está configurada
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey) && $this->apiKey !== 'TU_API_KEY';
    }

    /**
     * Obtiene la URL de la API de Google Maps con la key
     */
    public function getMapsApiUrl(): string
    {
        return "https://maps.googleapis.com/maps/api/js?key={$this->apiKey}&libraries=places";
    }

    /**
     * Obtiene la URL para geocodificación
     */
    public function getGeocodingUrl(): string
    {
        return "https://maps.googleapis.com/maps/api/geocode/json?key={$this->apiKey}";
    }

    /**
     * Obtiene la URL para direcciones
     */
    public function getDirectionsUrl(): string
    {
        return "https://maps.googleapis.com/maps/api/directions/json?key={$this->apiKey}";
    }
} 