<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\TarifaEnvioModel;
use App\Models\ConfiguracionModel;

class EnvioController extends Controller
{
    protected $tarifaEnvioModel;
    protected $configuracionModel;

    public function __construct()
    {
        $this->tarifaEnvioModel = new TarifaEnvioModel();
        $this->configuracionModel = new ConfiguracionModel();
    }

    /**
     * Calcular costo de envío basado en distancia
     */
    public function calcularCosto()
    {
        $distancia = $this->request->getPost('distancia');
        
        // Log para depuración
        log_message('info', "EnvioController - Distancia recibida: " . var_export($distancia, true));
        log_message('info', "EnvioController - Tipo de dato: " . gettype($distancia));
        log_message('info', "EnvioController - is_numeric: " . (is_numeric($distancia) ? 'true' : 'false'));
        
        if (!$distancia || !is_numeric($distancia)) {
            log_message('error', "EnvioController - Distancia inválida: {$distancia}");
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Distancia inválida'
            ]);
        }
        
        // Calcular costo usando el modelo de tarifas
        $resultado = $this->tarifaEnvioModel->calcularCostoEnvio($distancia);
        
        log_message('info', "EnvioController - Resultado: " . json_encode($resultado));
        
        return $this->response->setJSON([
            'success' => true,
            'costo' => $resultado['costo'],
            'tarifa' => $resultado['tarifa']
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