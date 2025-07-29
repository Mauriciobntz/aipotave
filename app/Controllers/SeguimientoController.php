<?php
namespace App\Controllers;

use App\Models\PedidoModel;
use App\Models\UbicacionRepartidorModel;
use CodeIgniter\Controller;

/**
 * Controlador para el seguimiento de pedidos en tiempo real
 */
class SeguimientoController extends Controller
{
    protected $pedidoModel;
    protected $ubicacionModel;

    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
        $this->ubicacionModel = new UbicacionRepartidorModel();
    }

    /**
     * Muestra la página de seguimiento para el cliente
     */
    public function seguimiento($codigo_seguimiento = null)
    {
        if (!$codigo_seguimiento) {
            $data = [
                'title' => 'Seguir mi Pedido'
            ];
            
            return view('header', $data)
                . view('navbar')
                . view('seguimiento/buscar_pedido')
                . view('footer');
        }

        // Obtener pedido con información del repartidor
        $pedido = $this->pedidoModel
            ->select('pedidos.*, repartidores.nombre as repartidor_nombre')
            ->join('repartidores', 'repartidores.id = pedidos.repartidor_id', 'left')
            ->where('pedidos.codigo_seguimiento', $codigo_seguimiento)
            ->first();
        
        if (!$pedido) {
            $data = [
                'title' => 'Pedido no encontrado',
                'codigo' => $codigo_seguimiento
            ];
            
            return view('header', $data)
                . view('navbar')
                . view('seguimiento/pedido_no_encontrado')
                . view('footer');
        }

        // Obtener la última ubicación del repartidor si el pedido está en camino
        $ubicacion_repartidor = null;
        if ($pedido['estado'] == 'en_camino' && $pedido['repartidor_id']) {
            $ubicacion_repartidor = $this->ubicacionModel
                ->where('repartidor_id', $pedido['repartidor_id'])
                ->orderBy('fecha', 'DESC')
                ->first();
        }

        $data = [
            'title' => 'Seguimiento del Pedido',
            'pedido' => $pedido,
            'ubicacion_repartidor' => $ubicacion_repartidor
        ];

        return view('header', $data)
            . view('navbar')
            . view('seguimiento/seguimiento')
            . view('footer');
    }

    /**
     * API para obtener la ubicación actual del repartidor
     */
    public function ubicacionRepartidor($pedido_id)
    {
        $pedido = $this->pedidoModel->find($pedido_id);
        
        if (!$pedido || !$pedido['repartidor_id']) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Pedido no encontrado o sin repartidor asignado'
            ]);
        }

        $ubicacion = $this->ubicacionModel
            ->where('repartidor_id', $pedido['repartidor_id'])
            ->orderBy('fecha', 'DESC')
            ->first();

        if (!$ubicacion) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Ubicación del repartidor no disponible'
            ]);
        }

        // Obtener nombre del repartidor
        $repartidor = \Config\Database::connect()->table('repartidores')
            ->where('id', $pedido['repartidor_id'])
            ->get()
            ->getRowArray();

        return $this->response->setJSON([
            'success' => true,
            'data' => [
                'latitud' => $ubicacion['latitud'],
                'longitud' => $ubicacion['longitud'],
                'fecha_actualizacion' => $ubicacion['fecha'],
                'estado_pedido' => $pedido['estado'],
                'repartidor_nombre' => $repartidor ? $repartidor['nombre'] : 'Repartidor'
            ]
        ]);
    }

    /**
     * API para obtener información del pedido
     */
    public function infoPedido($codigo_seguimiento)
    {
        $pedido = $this->pedidoModel
            ->select('pedidos.*, repartidores.nombre as repartidor_nombre')
            ->join('repartidores', 'repartidores.id = pedidos.repartidor_id', 'left')
            ->where('pedidos.codigo_seguimiento', $codigo_seguimiento)
            ->first();
        
        if (!$pedido) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Pedido no encontrado'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => [
                'id' => $pedido['id'],
                'codigo_pedido' => $pedido['codigo_seguimiento'],
                'estado' => $pedido['estado'],
                'fecha' => $pedido['fecha'],
                'total' => $pedido['total'],
                'direccion_entrega' => $pedido['direccion_entrega'],
                'repartidor_nombre' => $pedido['repartidor_nombre'] ?? null,
                'repartidor_id' => $pedido['repartidor_id']
            ]
        ]);
    }
} 