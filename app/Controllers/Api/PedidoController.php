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
     * @param string $codigo_seguimiento
     * @return Response
     */
    public function actualizarEstado($codigo_seguimiento)
    {
        // Verificar API key
        $apiKey = $this->request->getHeaderLine('X-API-Key');
        if (!$this->validarApiKey($apiKey)) {
            return $this->failUnauthorized('API key inválida');
        }

        // Validar que el pedido existe
        $pedido = $this->pedidoModel->getByCodigoSeguimiento($codigo_seguimiento);
        if (!$pedido) {
            return $this->failNotFound('Pedido no encontrado');
        }

        // Obtener el nuevo estado del body
        $json = $this->request->getJSON();
        if (!isset($json->estado)) {
            return $this->fail('El campo estado es requerido', 400);
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
                        'codigo_seguimiento' => $codigo_seguimiento,
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
     * @param string $codigo_seguimiento
     * @return Response
     */
    public function obtenerEstado($codigo_seguimiento)
    {
        // Verificar API key
        $apiKey = $this->request->getHeaderLine('X-API-Key');
        if (!$this->validarApiKey($apiKey)) {
            return $this->failUnauthorized('API key inválida');
        }

        // Buscar el pedido
        $pedido = $this->pedidoModel->getByCodigoSeguimiento($codigo_seguimiento);
        if (!$pedido) {
            return $this->failNotFound('Pedido no encontrado');
        }

        // Preparar respuesta
        $response = [
            'status' => 'success',
            'data' => [
                'pedido_id' => $pedido['id'],
                'codigo_seguimiento' => $codigo_seguimiento,
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
        // Obtener la API key válida del archivo de configuración
        $validApiKey = getenv('api.key') ?: config('App')->apiKey;
        
        return hash_equals($validApiKey, $apiKey);
    }
}
