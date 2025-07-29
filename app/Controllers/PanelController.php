<?php

namespace App\Controllers;

use App\Models\PedidoModel;
use App\Models\DetallePedidoModel;
use App\Models\RepartidorModel;
use CodeIgniter\Controller;

class PanelController extends Controller
{
    public function dashboard()
    {
        return $this->verPanel();
    }

    public function verPanel()
    {
        $pedidoModel = new \App\Models\PedidoModel();
        $repartidorModel = new RepartidorModel();
        
        // Obtener filtros
        $estado_filtro = $this->request->getGet('estado') ?? '';
        $metodo_filtro = $this->request->getGet('metodo') ?? '';
        $fecha_desde = $this->request->getGet('fecha_desde') ?? '';
        $fecha_hasta = $this->request->getGet('fecha_hasta') ?? '';
        $buscar = $this->request->getGet('buscar') ?? '';
        
        // Construir consulta
        $db = \Config\Database::connect();
        $builder = $db->table('pedidos');
        $builder->select('pedidos.*, repartidores.nombre as nombre_repartidor');
        $builder->join('repartidores', 'pedidos.repartidor_id = repartidores.id', 'left');
        
        // Aplicar filtros
        if (!empty($estado_filtro)) {
            $builder->where('pedidos.estado', $estado_filtro);
        }
        
        if (!empty($metodo_filtro)) {
            $builder->where('pedidos.metodo_pago', $metodo_filtro);
        }
        
        if (!empty($fecha_desde)) {
            $builder->where('pedidos.fecha >=', $fecha_desde . ' 00:00:00');
        }
        
        if (!empty($fecha_hasta)) {
            $builder->where('pedidos.fecha <=', $fecha_hasta . ' 23:59:59');
        }
        
        if (!empty($buscar)) {
            $builder->groupStart()
                ->like('pedidos.nombre', $buscar)
                ->orLike('pedidos.codigo_seguimiento', $buscar)
                ->orLike('pedidos.correo_electronico', $buscar)
                ->groupEnd();
        }
        
        $pedidos = $builder->orderBy('pedidos.fecha', 'desc')->get()->getResultArray();
        
        // Calcular métricas
        $total_pedidos = count($pedidos);
        $pendientes = count(array_filter($pedidos, function($p) { 
            return $p['estado'] === 'pendiente'; 
        }));
        $en_preparacion = count(array_filter($pedidos, function($p) { 
            return $p['estado'] === 'en_preparacion'; 
        }));
        $entregados_hoy = count(array_filter($pedidos, function($p) { 
            return $p['estado'] === 'entregado' && 
                   date('Y-m-d', strtotime($p['fecha'])) === date('Y-m-d'); 
        }));
        
        // Obtener repartidores para el modal
        $repartidores = $repartidorModel->listarActivos();
        
        $data = [
            'pedidos' => array_values($pedidos), // Reindexar array
            'total_pedidos' => $total_pedidos,
            'pendientes' => $pendientes,
            'en_preparacion' => $en_preparacion,
            'entregados_hoy' => $entregados_hoy,
            'repartidores' => $repartidores,
            'estado_filtro' => $estado_filtro,
            'metodo_filtro' => $metodo_filtro,
            'fecha_desde' => $fecha_desde,
            'fecha_hasta' => $fecha_hasta,
            'buscar' => $buscar
        ];
        
        return view('panel/pedidos', $data);
    }

    public function detallePedido($id)
    {
        $pedidoModel = new PedidoModel();
        $detalleModel = new DetallePedidoModel();
        
        $pedido = $pedidoModel->getById($id);
        if (!$pedido) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pedido no encontrado');
        }
        
        $detalles = $detalleModel->getDetallesConInfo($id);
        
        $data = [
            'pedido' => $pedido,
            'detalles' => $detalles
        ];
        
        return view('panel/pedido_detalle', $data);
    }

    public function cambiarEstado()
    {
        $pedido_id = $this->request->getPost('pedido_id');
        $nuevo_estado = $this->request->getPost('nuevo_estado');
        
        $pedidoModel = new PedidoModel();
        
        try {
            $pedidoModel->actualizarEstado($pedido_id, $nuevo_estado);
            
            // Enviar webhook a Make/Integromat
            $this->enviarWebhook($pedido_id, $nuevo_estado);
            
            return $this->response->setJSON(['success' => true]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function asignarRepartidor()
    {
        $pedido_id = $this->request->getPost('pedido_id');
        $repartidor_id = $this->request->getPost('repartidor_id');
        
        $pedidoModel = new PedidoModel();
        
        try {
            $pedidoModel->asignarRepartidor($pedido_id, $repartidor_id);
            return $this->response->setJSON(['success' => true]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function enviarWebhook($pedido_id, $nuevo_estado)
    {
        // URL del webhook de Make/Integromat
        $webhook_url = 'https://hook.eu1.make.com/tu-webhook-id';
        
        $data = [
            'pedido_id' => $pedido_id,
            'estado' => $nuevo_estado,
            'timestamp' => date('Y-m-d H:i:s'),
            'webhook_source' => 'restaurante_system'
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $webhook_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        // Log del webhook (opcional)
        log_message('info', "Webhook enviado para pedido {$pedido_id} con estado {$nuevo_estado}");
    }
} 