<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class EnvioController extends Controller
{
    /**
     * Calcular costo de envío basado en coordenadas
     */
    public function calcularCosto()
    {
        $lat = $this->request->getPost('lat');
        $lng = $this->request->getPost('lng');
        
        if (empty($lat) || empty($lng)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Coordenadas requeridas'
            ]);
        }
        
        // Calcular costo usando el helper
        $costo = calcular_costo_envio($lat, $lng);
        $distancia = calcular_distancia(-25.291388888889, -57.718333333333, $lat, $lng);
        $distanciaTexto = obtener_distancia_texto($lat, $lng);
        $enZona = validar_zona_entrega($lat, $lng);
        
        return $this->response->setJSON([
            'success' => true,
            'costo' => $costo,
            'distancia' => $distancia,
            'distanciaTexto' => $distanciaTexto,
            'enZona' => $enZona,
            'formateado' => formatear_costo_envio($costo)
        ]);
    }
    
    /**
     * Validar si una ubicación está en zona de entrega
     */
    public function validarZona()
    {
        $lat = $this->request->getPost('lat');
        $lng = $this->request->getPost('lng');
        
        if (empty($lat) || empty($lng)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Coordenadas requeridas'
            ]);
        }
        
        $enZona = validar_zona_entrega($lat, $lng);
        $distancia = calcular_distancia(-25.291388888889, -57.718333333333, $lat, $lng);
        
        return $this->response->setJSON([
            'success' => true,
            'enZona' => $enZona,
            'distancia' => $distancia,
            'distanciaTexto' => obtener_distancia_texto($lat, $lng)
        ]);
    }
    
    /**
     * Obtener información de tarifas
     */
    public function tarifas()
    {
        return $this->response->setJSON([
            'success' => true,
            'tarifas' => [
                [
                    'distancia' => 'Hasta 1.5 km',
                    'costo' => 1000,
                    'descripcion' => 'Envío local'
                ],
                [
                    'distancia' => 'Más de 1.5 km',
                    'costo' => 1500,
                    'descripcion' => 'Envío extendido'
                ]
            ],
            'zonaMaxima' => 10, // km
            'coordenadasRestaurante' => [
                'lat' => -25.291388888889,
                'lng' => -57.718333333333
            ]
        ]);
    }
} 