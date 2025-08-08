<?php
namespace App\Controllers;

use App\Models\UbicacionRepartidorModel;
use App\Models\PedidoModel;
use CodeIgniter\RESTful\ResourceController;

/**
 * API para ubicaciones de repartidores.
 */
class ApiController extends ResourceController
{
    /**
     * Devuelve la última ubicación del repartidor para un pedido (JSON).
     * @param int $repartidor_id
     * @param int $pedido_id
     */
    public function ubicacion($repartidor_id, $pedido_id)
    {
        $ubicacionModel = new UbicacionRepartidorModel();
        $pedidoModel = new PedidoModel();
        
        // Verificar que el pedido existe y tiene un repartidor asignado
        $pedido = $pedidoModel->find($pedido_id);
        if (!$pedido) {
            return $this->respond([
                'success' => false,
                'message' => 'Pedido no encontrado'
            ], 404);
        }
        
        if (!$pedido['repartidor_id']) {
            return $this->respond([
                'success' => false,
                'message' => 'Pedido no tiene repartidor asignado'
            ], 404);
        }
        
        // Obtener la última ubicación del repartidor para este pedido
        $ubicacion = $ubicacionModel->getUbicacionPorPedido($pedido['repartidor_id'], $pedido_id);
        
        if (!$ubicacion) {
            // Si no hay ubicación específica para este pedido, intentar obtener la última ubicación general del repartidor
            $ubicacion = $ubicacionModel->getUltimaUbicacion($pedido['repartidor_id']);
            
            if (!$ubicacion) {
                return $this->respond([
                    'success' => false,
                    'message' => 'No hay ubicación disponible del repartidor',
                    'data' => null
                ], 404);
            }
        }
        
        return $this->respond([
            'success' => true,
            'message' => 'Ubicación obtenida correctamente',
            'data' => [
                'latitud' => $ubicacion['latitud'],
                'longitud' => $ubicacion['longitud'],
                'fecha' => $ubicacion['fecha'],
                'fecha_actualizacion' => $ubicacion['fecha'],
                'repartidor_nombre' => $pedido['repartidor_nombre'] ?? 'Repartidor'
            ]
        ]);
    }
    
    /**
     * Devuelve la última ubicación del repartidor para seguimiento (JSON).
     * @param int $pedido_id
     */
    public function seguimientoUbicacion($pedido_id)
    {
        $ubicacionModel = new UbicacionRepartidorModel();
        $pedidoModel = new PedidoModel();
        
        // Verificar que el pedido existe y tiene un repartidor asignado
        $pedido = $pedidoModel->find($pedido_id);
        if (!$pedido) {
            return $this->respond([
                'success' => false,
                'message' => 'Pedido no encontrado'
            ], 404);
        }
        
        if (!$pedido['repartidor_id']) {
            return $this->respond([
                'success' => false,
                'message' => 'Pedido no tiene repartidor asignado'
            ], 404);
        }
        
        // Obtener la última ubicación del repartidor para este pedido
        $ubicacion = $ubicacionModel->getUbicacionPorPedido($pedido['repartidor_id'], $pedido_id);
        
        if (!$ubicacion) {
            // Si no hay ubicación específica para este pedido, intentar obtener la última ubicación general del repartidor
            $ubicacion = $ubicacionModel->getUltimaUbicacion($pedido['repartidor_id']);
            
            if (!$ubicacion) {
                return $this->respond([
                    'success' => false,
                    'message' => 'No hay ubicación disponible del repartidor',
                    'data' => null
                ], 404);
            }
        }
        
        return $this->respond([
            'success' => true,
            'message' => 'Ubicación obtenida correctamente',
            'data' => [
                'latitud' => $ubicacion['latitud'],
                'longitud' => $ubicacion['longitud'],
                'fecha' => $ubicacion['fecha'],
                'fecha_actualizacion' => $ubicacion['fecha'],
                'repartidor_nombre' => $pedido['repartidor_nombre'] ?? 'Repartidor'
            ]
        ]);
    }
} 