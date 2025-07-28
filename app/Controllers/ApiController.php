<?php
namespace App\Controllers;

use App\Models\RepartidorModel;
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
        $model = new RepartidorModel();
        $ubicacion = $model->getUltimaUbicacion($repartidor_id, $pedido_id);
        if (!$ubicacion) {
            return $this->failNotFound('Ubicación no encontrada');
        }
        return $this->respond([
            'latitud' => $ubicacion['latitud'],
            'longitud' => $ubicacion['longitud'],
            'fecha' => $ubicacion['fecha']
        ]);
    }
} 