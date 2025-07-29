<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class GoogleMapsController extends Controller
{
    public function index()
    {
        return view('ejemplo_google_maps');
    }
    
    /**
     * API para geocodificar una dirección
     */
    public function geocode()
    {
        $address = $this->request->getPost('address');
        
        if (!$address) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Dirección requerida'
            ]);
        }
        
        $result = google_maps_geocode($address);
        
        if ($result) {
            return $this->response->setJSON([
                'success' => true,
                'lat' => $result['lat'],
                'lng' => $result['lng']
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No se pudo geocodificar la dirección'
            ]);
        }
    }
    
    /**
     * API para geocodificación inversa
     */
    public function reverseGeocode()
    {
        $lat = $this->request->getPost('lat');
        $lng = $this->request->getPost('lng');
        
        if (!$lat || !$lng) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Latitud y longitud requeridas'
            ]);
        }
        
        $address = google_maps_reverse_geocode($lat, $lng);
        
        if ($address) {
            return $this->response->setJSON([
                'success' => true,
                'address' => $address
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No se pudo obtener la dirección'
            ]);
        }
    }
    
    /**
     * API para obtener direcciones
     */
    public function directions()
    {
        $origin = $this->request->getPost('origin');
        $destination = $this->request->getPost('destination');
        
        if (!$origin || !$destination) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Origen y destino requeridos'
            ]);
        }
        
        $result = google_maps_directions($origin, $destination);
        
        if ($result) {
            return $this->response->setJSON([
                'success' => true,
                'directions' => $result
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No se pudieron obtener las direcciones'
            ]);
        }
    }
    
    /**
     * Verificar si Google Maps está configurado
     */
    public function status()
    {
        $config = config('GoogleMaps');
        
        return $this->response->setJSON([
            'configured' => $config->isConfigured(),
            'hasApiKey' => !empty($config->apiKey),
            'apiKeyLength' => strlen($config->apiKey)
        ]);
    }
} 