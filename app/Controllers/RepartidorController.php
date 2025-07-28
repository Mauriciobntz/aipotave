<?php
namespace App\Controllers;

use App\Models\PedidoModel;
use App\Models\DetallePedidoModel;
use App\Models\RepartidorModel;
use App\Models\HistorialEstadosModel;
use App\Models\UbicacionRepartidorModel;
use App\Controllers\NotificacionController;
use CodeIgniter\Controller;

/**
 * Controlador para el panel de repartidor y actualización de ubicación.
 */
class RepartidorController extends Controller
{
    protected $pedidoModel;
    protected $detalleModel;
    protected $repartidorModel;
    protected $historialModel;
    protected $ubicacionModel;
    protected $notificacionController;

    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
        $this->detalleModel = new DetallePedidoModel();
        $this->repartidorModel = new RepartidorModel();
        $this->historialModel = new HistorialEstadosModel();
        $this->ubicacionModel = new UbicacionRepartidorModel();
        $this->notificacionController = new NotificacionController();
    }

    /**
     * Muestra los pedidos asignados al repartidor (simulación: id=1).
     */
    public function pedidos()
    {
        $repartidor_id = 1; // Simulación, reemplazar por el ID real del repartidor logueado
        
        // Obtener filtros de la URL
        $estado_filtro = $this->request->getGet('estado') ?? '';
        $fecha_desde = $this->request->getGet('fecha_desde') ?? '';
        $fecha_hasta = $this->request->getGet('fecha_hasta') ?? '';
        $orden = $this->request->getGet('orden') ?? 'fecha_desc';
        
        $pedidos = $this->pedidoModel->getPedidosConRepartidor();
        $pedidos_asignados = array_filter($pedidos, function($pedido) use ($repartidor_id) {
            return $pedido['repartidor_id'] == $repartidor_id && 
                   in_array($pedido['estado'], ['en_camino', 'entregado']);
        });
        
        // Aplicar filtros adicionales
        if (!empty($estado_filtro)) {
            $pedidos_asignados = array_filter($pedidos_asignados, function($pedido) use ($estado_filtro) {
                return $pedido['estado'] == $estado_filtro;
            });
        }
        
        if (!empty($fecha_desde)) {
            $pedidos_asignados = array_filter($pedidos_asignados, function($pedido) use ($fecha_desde) {
                return date('Y-m-d', strtotime($pedido['fecha'])) >= $fecha_desde;
            });
        }
        
        if (!empty($fecha_hasta)) {
            $pedidos_asignados = array_filter($pedidos_asignados, function($pedido) use ($fecha_hasta) {
                return date('Y-m-d', strtotime($pedido['fecha'])) <= $fecha_hasta;
            });
        }
        
        // Aplicar ordenamiento
        usort($pedidos_asignados, function($a, $b) use ($orden) {
            switch($orden) {
                case 'fecha_asc':
                    return strtotime($a['fecha']) - strtotime($b['fecha']);
                case 'fecha_desc':
                    return strtotime($b['fecha']) - strtotime($a['fecha']);
                case 'prioridad':
                    // Ordenar por prioridad (pendiente primero, luego en_camino, luego entregado)
                    $prioridad = ['en_camino' => 1, 'entregado' => 2];
                    $prioridad_a = $prioridad[$a['estado']] ?? 3;
                    $prioridad_b = $prioridad[$b['estado']] ?? 3;
                    return $prioridad_a - $prioridad_b;
                default:
                    return strtotime($b['fecha']) - strtotime($a['fecha']);
            }
        });
        
        $data = [
            'title' => 'Mis Pedidos',
            'pedidos' => $pedidos_asignados,
            'estado_filtro' => $estado_filtro,
            'fecha_desde' => $fecha_desde,
            'fecha_hasta' => $fecha_hasta,
            'orden' => $orden
        ];
        return view('header', $data)
            . view('navbar')
            . view('repartidor/pedidos')
            . view('footer_repartidor');
    }

    /**
     * Muestra el detalle de un pedido asignado al repartidor.
     * @param int $id
     */
    public function detalle($id)
    {
        $repartidor_id = 1; // Simulación, reemplazar por el ID real del repartidor logueado
        
        $pedido = $this->pedidoModel->getById($id);
        if (!$pedido || $pedido['repartidor_id'] != $repartidor_id) {
            return redirect()->to(base_url('repartidor/pedidos'))->with('error', 'Pedido no encontrado o no asignado.');
        }
        
        $detalles = $this->detalleModel->getDetallesConInfo($id);
        $historial = $this->historialModel->getByPedidoId($id);
        $ultima_ubicacion = $this->ubicacionModel->getUltimaUbicacion($repartidor_id, $id);
        
        $data = [
            'title' => 'Detalle de Pedido',
            'pedido' => $pedido,
            'detalles' => $detalles,
            'historial' => $historial,
            'ultima_ubicacion' => $ultima_ubicacion
        ];
        return view('header', $data)
            . view('navbar')
            . view('repartidor/pedido_detalle')
            . view('footer_repartidor');
    }

    /**
     * Recibe la ubicación en tiempo real del repartidor (POST: pedido_id, latitud, longitud).
     */
    public function actualizarUbicacion()
    {
        $repartidor_id = 1; // Simulación, reemplazar por el ID real del repartidor logueado
        $pedido_id = $this->request->getPost('pedido_id');
        $latitud = $this->request->getPost('latitud');
        $longitud = $this->request->getPost('longitud');
        
        if (!$pedido_id || !$latitud || !$longitud) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Datos incompletos']);
        }

        // Verificar que el pedido está asignado al repartidor
        $pedido = $this->pedidoModel->find($pedido_id);
        if (!$pedido || $pedido['repartidor_id'] != $repartidor_id) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Pedido no asignado']);
        }

        if ($this->ubicacionModel->registrarUbicacion($repartidor_id, $pedido_id, $latitud, $longitud)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Error al actualizar ubicación']);
        }
    }

    /**
     * Cambia el estado de un pedido desde el repartidor.
     * @param int $id
     */
    public function cambiarEstado($id)
    {
        $repartidor_id = 1; // Simulación, reemplazar por el ID real del repartidor logueado
        $nuevo_estado = $this->request->getPost('estado');
        
        if (!in_array($nuevo_estado, ['en_camino', 'entregado'])) {
            return redirect()->back()->with('error', 'Estado no válido para repartidor');
        }

        $pedido = $this->pedidoModel->find($id);
        if (!$pedido || $pedido['repartidor_id'] != $repartidor_id) {
            return redirect()->back()->with('error', 'Pedido no encontrado o no asignado');
        }

        if ($this->pedidoModel->actualizarEstado($id, $nuevo_estado)) {
            // Enviar notificación al cliente
            $this->notificacionController->enviarNotificacionEstado($id, $nuevo_estado);
            
            return redirect()->back()->with('success', 'Estado del pedido actualizado correctamente');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el estado del pedido');
        }
    }

    /**
     * Muestra la ruta del repartidor para un pedido
     */
    public function ruta($pedido_id)
    {
        $repartidor_id = 1; // Simulación, reemplazar por el ID real del repartidor logueado
        
        $pedido = $this->pedidoModel->find($pedido_id);
        if (!$pedido || $pedido['repartidor_id'] != $repartidor_id) {
            return redirect()->to(base_url('repartidor/pedidos'))->with('error', 'Pedido no encontrado o no asignado.');
        }
        
        $ruta = $this->ubicacionModel->getRuta($repartidor_id, $pedido_id);
        
        $data = [
            'title' => 'Ruta del Pedido',
            'pedido' => $pedido,
            'ruta' => $ruta
        ];
        return view('header', $data)
            . view('navbar')
            . view('repartidor/ruta')
            . view('footer_repartidor');
    }

    /**
     * Actualiza la disponibilidad del repartidor
     */
    public function actualizarDisponibilidad()
    {
        $repartidor_id = 1; // Simulación, reemplazar por el ID real del repartidor logueado
        $disponible = $this->request->getPost('disponible') == '1';
        
        if ($this->repartidorModel->actualizarDisponibilidad($repartidor_id, $disponible)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Error al actualizar disponibilidad']);
        }
    }

    /**
     * Muestra estadísticas del repartidor
     */
    public function estadisticas()
    {
        $repartidor_id = 1; // Simulación, reemplazar por el ID real del repartidor logueado
        $fecha_inicio = $this->request->getGet('fecha_inicio') ?? date('Y-m-d', strtotime('-7 days'));
        $fecha_fin = $this->request->getGet('fecha_fin') ?? date('Y-m-d');

        // Obtener pedidos del repartidor
        $pedidos = $this->pedidoModel->getPedidosConRepartidor();
        $pedidos_repartidor = array_filter($pedidos, function($pedido) use ($repartidor_id) {
            return $pedido['repartidor_id'] == $repartidor_id;
        });

        // Filtrar por fechas
        $pedidos_filtrados = array_filter($pedidos_repartidor, function($pedido) use ($fecha_inicio, $fecha_fin) {
            $fecha_pedido = date('Y-m-d', strtotime($pedido['fecha']));
            return $fecha_pedido >= $fecha_inicio && $fecha_pedido <= $fecha_fin;
        });

        // Contar por estado
        $estadisticas = [];
        $estados_colores = [
            'en_camino' => 'primary',
            'entregado' => 'success',
            'cancelado' => 'danger'
        ];

        foreach ($pedidos_filtrados as $pedido) {
            $estado = $pedido['estado'];
            if (!isset($estadisticas[$estado])) {
                $estadisticas[$estado] = [
                    'cantidad' => 0,
                    'color' => $estados_colores[$estado] ?? 'secondary'
                ];
            }
            $estadisticas[$estado]['cantidad']++;
        }

        // Calcular métricas
        $entregas_hoy = count(array_filter($pedidos_repartidor, function($pedido) {
            return $pedido['estado'] === 'entregado' && 
                   date('Y-m-d', strtotime($pedido['fecha'])) === date('Y-m-d');
        }));

        $entregas_semana = count(array_filter($pedidos_repartidor, function($pedido) {
            return $pedido['estado'] === 'entregado' && 
                   date('Y-m-d', strtotime($pedido['fecha'])) >= date('Y-m-d', strtotime('-7 days'));
        }));

        // Tiempo promedio de entrega (simulado)
        $tiempo_promedio_entrega = 35; // minutos
        
        // Calificación promedio (simulado)
        $calificacion_promedio = 4.5;

        $data = [
            'title' => 'Estadísticas de Repartidor',
            'estadisticas' => $estadisticas,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'entregas_hoy' => $entregas_hoy,
            'entregas_semana' => $entregas_semana,
            'tiempo_promedio_entrega' => $tiempo_promedio_entrega,
            'calificacion_promedio' => $calificacion_promedio
        ];
        return view('header', $data)
            . view('navbar')
            . view('repartidor/estadisticas')
            . view('footer_repartidor');
    }

    /**
     * Marca el pago de un pedido como recibido por el repartidor
     */
    public function marcarPagoRecibido()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Solicitud inválida']);
        }

        $pedidoId = $this->request->getJSON()->pedido_id;
        
        if (!$pedidoId) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID de pedido requerido']);
        }

        $pedidoModel = new \App\Models\PedidoModel();
        $pedido = $pedidoModel->find($pedidoId);
        
        if (!$pedido) {
            return $this->response->setJSON(['success' => false, 'message' => 'Pedido no encontrado']);
        }

        // Verificar que el pedido esté asignado al repartidor actual
        if ($pedido['repartidor_id'] != session('user_id')) {
            return $this->response->setJSON(['success' => false, 'message' => 'No tienes permisos para este pedido']);
        }

        // Verificar que el pago esté pendiente y sea en efectivo
        if ($pedido['estado_pago'] != 'pendiente' || $pedido['metodo_pago'] != 'efectivo') {
            return $this->response->setJSON(['success' => false, 'message' => 'El pago no está pendiente o no es en efectivo']);
        }

        // Marcar como pagado
        $resultado = $pedidoModel->update($pedidoId, ['estado_pago' => 'pagado']);
        
        if ($resultado) {
            return $this->response->setJSON(['success' => true, 'message' => 'Pago marcado como recibido']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al actualizar el estado del pago']);
        }
    }
} 