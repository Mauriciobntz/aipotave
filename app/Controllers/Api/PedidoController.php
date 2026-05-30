<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PedidoModel;
use App\Models\HistorialEstadosModel;
use CodeIgniter\API\ResponseTrait;

class PedidoController extends ResourceController
{
    use ResponseTrait;

    protected $pedidoModel;
    protected $historialModel;
    protected $format = 'json';

    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
        $this->historialModel = new HistorialEstadosModel();
    }

    /**
     * Actualiza el estado de un pedido a través de la API
     * 
     * @return Response
     */
    public function actualizarEstado()
    {
        // Verificar API key
        $apiKey = $this->request->getHeaderLine('X-API-Key');
        if (!$this->validarApiKey($apiKey)) {
            return $this->failUnauthorized('API key inválida');
        }

        // Obtener datos del body
        $json = $this->request->getJSON();
        
        // Validar que el código del pedido esté en el body
        if (!isset($json->codigo_pedido)) {
            return $this->fail('El campo codigo_pedido es requerido', 400);
        }
        
        if (!isset($json->estado)) {
            return $this->fail('El campo estado es requerido', 400);
        }

        // Validar que el pedido existe
        $pedido = $this->pedidoModel->getByCodigoSeguimiento($json->codigo_pedido);
        if (!$pedido) {
            return $this->failNotFound('Pedido no encontrado');
        }

        $nuevoEstado = $json->estado;
        $estadosValidos = ['pendiente', 'confirmado', 'en_preparacion', 'listo', 'en_camino', 'entregado', 'cancelado'];
        
        if (!in_array($nuevoEstado, $estadosValidos)) {
            return $this->fail('Estado inválido. Estados válidos: ' . implode(', ', $estadosValidos), 400);
        }

        try {
            // Actualizar el estado
            $actualizado = $this->pedidoModel->actualizarEstado($pedido['id'], $nuevoEstado);
            
            if ($actualizado) {
                // Registrar en el historial
                $this->historialModel->registrarCambio(
                    $pedido['id'], 
                    $pedido['estado'], 
                    $nuevoEstado,
                    'API - Whatsapp'
                );

                // Preparar respuesta
                $response = [
                    'status' => 'success',
                    'message' => 'Estado actualizado correctamente',
                    'data' => [
                        'pedido_id' => $pedido['id'],
                        'codigo_seguimiento' => $json->codigo_pedido,
                        'estado_anterior' => $pedido['estado'],
                        'estado_nuevo' => $nuevoEstado,
                        'fecha_actualizacion' => date('Y-m-d H:i:s')
                    ]
                ];

                return $this->respond($response, 200);
            }

            return $this->fail('No se pudo actualizar el estado del pedido', 500);

        } catch (\Exception $e) {
            log_message('error', 'Error al actualizar estado de pedido: ' . $e->getMessage());
            return $this->fail($e->getMessage(), 500);
        }
    }

    /**
     * Obtiene el estado actual de un pedido
     * 
     * @return Response
     */
    public function obtenerEstado()
    {
        // Verificar API key
        $apiKey = $this->request->getHeaderLine('X-API-Key');
        if (!$this->validarApiKey($apiKey)) {
            return $this->failUnauthorized('API key inválida');
        }

        // Obtener datos del body
        $json = $this->request->getJSON();
        
        // Validar que el código del pedido esté en el body
        if (!isset($json->codigo_pedido)) {
            return $this->fail('El campo codigo_pedido es requerido', 400);
        }

        // Buscar el pedido
        $pedido = $this->pedidoModel->getByCodigoSeguimiento($json->codigo_pedido);
        if (!$pedido) {
            return $this->failNotFound('Pedido no encontrado');
        }

        // Preparar respuesta
        $response = [
            'status' => 'success',
            'data' => [
                'pedido_id' => $pedido['id'],
                'codigo_seguimiento' => $json->codigo_pedido,
                'estado' => $pedido['estado'],
                'fecha_actualizacion' => $pedido['fecha']
            ]
        ];

        return $this->respond($response, 200);
    }

    /**
     * Valida la API key
     * 
     * @param string $apiKey
     * @return bool
     */
    private function validarApiKey($apiKey)
    {
        // Obtener la API key válida del archivo .env
        $validApiKey = env('api.key');
        
        return hash_equals($validApiKey, $apiKey);
    }
}