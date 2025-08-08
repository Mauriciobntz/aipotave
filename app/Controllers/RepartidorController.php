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
     * Muestra los pedidos asignados al repartidor logueado.
     */
    public function pedidos()
    {
        $repartidor_id = session()->get('user_id');
        
        // Verificar que el usuario esté logueado y sea repartidor
        if (!session()->get('logueado') || session()->get('user_role') !== 'repartidor') {
            return redirect()->to(base_url('login'));
        }
        
        // Obtener filtros de la URL
        $estado_filtro = $this->request->getGet('estado') ?? '';
        $fecha_desde = $this->request->getGet('fecha_desde') ?? '';
        $fecha_hasta = $this->request->getGet('fecha_hasta') ?? '';
        $orden = $this->request->getGet('orden') ?? 'fecha_desc';
        
        $pedidos = $this->pedidoModel->getPedidosConRepartidor();
        $pedidos_asignados = array_filter($pedidos, function($pedido) use ($repartidor_id) {
            return $pedido['repartidor_id'] == $repartidor_id && 
                   in_array($pedido['estado'], ['en_camino', 'entregado', 'cancelado']);
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
                    // Ordenar por prioridad: en_camino (más antiguo primero), luego entregado
                    if ($a['estado'] == 'en_camino' && $b['estado'] == 'en_camino') {
                        // Si ambos están en camino, ordenar por fecha (más antiguo primero)
                        return strtotime($a['fecha']) - strtotime($b['fecha']);
                    } elseif ($a['estado'] == 'en_camino') {
                        return -1; // en_camino va primero
                    } elseif ($b['estado'] == 'en_camino') {
                        return 1; // en_camino va primero
                    } else {
                        // Si ambos están entregados, ordenar por fecha (más reciente primero)
                        return strtotime($b['fecha']) - strtotime($a['fecha']);
                    }
                default:
                    // Ordenamiento por defecto: en_camino primero (más antiguo), luego entregado
                    if ($a['estado'] == 'en_camino' && $b['estado'] == 'en_camino') {
                        return strtotime($a['fecha']) - strtotime($b['fecha']);
                    } elseif ($a['estado'] == 'en_camino') {
                        return -1;
                    } elseif ($b['estado'] == 'en_camino') {
                        return 1;
                    } else {
                        return strtotime($b['fecha']) - strtotime($a['fecha']);
                    }
            }
        });
        
        // Agregar detalles a cada pedido
        foreach ($pedidos_asignados as &$pedido) {
            $pedido['detalles'] = $this->detalleModel->getDetallesConInfo($pedido['id']);
        }
        
        $data = [
            'title' => 'Mis Pedidos',
            'pedidos' => $pedidos_asignados,
            'estado_filtro' => $estado_filtro,
            'fecha_desde' => $fecha_desde,
            'fecha_hasta' => $fecha_hasta,
            'orden' => $orden
        ];
        return view('header', $data)
            . view('navbar_repartidor')
            . view('repartidor/pedidos')
            . view('footer_repartidor');
    }

    /**
     * Muestra el detalle de un pedido asignado al repartidor.
     * @param int $id
     */
    public function detalle($id)
    {
        $repartidor_id = session()->get('user_id');
        
        // Verificar que el usuario esté logueado y sea repartidor
        if (!session()->get('logueado') || session()->get('user_role') !== 'repartidor') {
            return redirect()->to(base_url('login'));
        }
        
        $pedidos = $this->pedidoModel->getPedidosConRepartidor();
        $pedido = null;
        foreach ($pedidos as $p) {
            if ($p['id'] == $id) {
                $pedido = $p;
                break;
            }
        }
        if (!$pedido || $pedido['repartidor_id'] != $repartidor_id) {
            return redirect()->to(base_url('repartidor/pedidos'))->with('error', 'Pedido no encontrado o no asignado.');
        }
        
        $detalles = $this->detalleModel->getDetallesConInfoMejorada($id);
        
        // Debug temporal
        log_message('debug', 'RepartidorController::detalle - detalles para pedido ' . $id . ': ' . json_encode($detalles));
        
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
            . view('navbar_repartidor')
            . view('repartidor/pedido_detalle')
            . view('footer_repartidor');
    }

    /**
     * Recibe la ubicación en tiempo real del repartidor (POST: pedido_id, latitud, longitud).
     */
    public function actualizarUbicacion()
    {
        $repartidor_id = session()->get('user_id');
        
        // Verificar que el usuario esté logueado y sea repartidor
        if (!session()->get('logueado') || session()->get('user_role') !== 'repartidor') {
            return $this->response->setStatusCode(401)->setJSON(['success' => false, 'message' => 'No autorizado']);
        }
        
        // Obtener datos del JSON
        $jsonData = $this->request->getJSON();
        $pedido_id = $jsonData->pedido_id ?? null;
        $latitud = $jsonData->latitud ?? null;
        $longitud = $jsonData->longitud ?? null;
        
        if (!$latitud || !$longitud) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Datos incompletos']);
        }

        // Si se proporciona un pedido_id, verificar que esté asignado al repartidor
        if ($pedido_id) {
            $pedido = $this->pedidoModel->find($pedido_id);
            if (!$pedido || $pedido['repartidor_id'] != $repartidor_id) {
                return $this->response->setStatusCode(403)->setJSON(['success' => false, 'message' => 'Pedido no asignado']);
            }
        }

        try {
            if ($this->ubicacionModel->registrarUbicacion($repartidor_id, $pedido_id, $latitud, $longitud)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Ubicación actualizada correctamente']);
            } else {
                return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Error al actualizar ubicación']);
            }
        } catch (Exception $e) {
            log_message('error', 'Error en actualizarUbicacion: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Error interno del servidor']);
        }
    }

    /**
     * Cambia el estado de un pedido desde el repartidor.
     */
    public function cambiarEstado()
    {
        $repartidor_id = session()->get('user_id');
        
        // Verificar que el usuario esté logueado y sea repartidor
        if (!session()->get('logueado') || session()->get('user_role') !== 'repartidor') {
            return $this->response->setStatusCode(401)->setJSON(['success' => false, 'message' => 'No autorizado']);
        }
        
        // Obtener datos del JSON
        $jsonData = $this->request->getJSON();
        $pedido_id = $jsonData->pedido_id ?? null;
        $nuevo_estado = $jsonData->estado ?? null;
        
        if (!$pedido_id || !$nuevo_estado) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Datos incompletos']);
        }
        
        if (!in_array($nuevo_estado, ['en_camino', 'entregado'])) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Estado no válido para repartidor']);
        }

        $pedido = $this->pedidoModel->find($pedido_id);
        if (!$pedido || $pedido['repartidor_id'] != $repartidor_id) {
            return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Pedido no encontrado o no asignado']);
        }

        try {
            if ($this->pedidoModel->actualizarEstado($pedido_id, $nuevo_estado)) {
                // Registrar en historial
                $this->historialModel->insert([
                    'pedido_id' => $pedido_id,
                    'estado' => $nuevo_estado,
                    'fecha_cambio' => date('Y-m-d H:i:s')
                ]);
                
                // Enviar notificación al cliente
                $this->notificacionController->enviarNotificacionEstado($pedido_id, $nuevo_estado);
                
                return $this->response->setJSON(['success' => true, 'message' => 'Estado del pedido actualizado correctamente']);
            } else {
                return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Error al actualizar el estado del pedido']);
            }
        } catch (Exception $e) {
            log_message('error', 'Error en cambiarEstado: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Error interno del servidor']);
        }
    }

    /**
     * Muestra la ruta del repartidor para un pedido
     */
    public function ruta($pedido_id)
    {
        $repartidor_id = session()->get('user_id');
        
        // Verificar que el usuario esté logueado y sea repartidor
        if (!session()->get('logueado') || session()->get('user_role') !== 'repartidor') {
            return redirect()->to(base_url('login'));
        }
        
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
            . view('navbar_repartidor')
            . view('repartidor/ruta')
            . view('footer_repartidor');
    }

    /**
     * Actualiza la disponibilidad del repartidor
     */
    public function actualizarDisponibilidad()
    {
        $repartidor_id = session()->get('user_id');
        
        // Verificar que el usuario esté logueado y sea repartidor
        if (!session()->get('logueado') || session()->get('user_role') !== 'repartidor') {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'No autorizado']);
        }
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
        $repartidor_id = session()->get('user_id');
        
        // Verificar que el usuario esté logueado y sea repartidor
        if (!session()->get('logueado') || session()->get('user_role') !== 'repartidor') {
            return redirect()->to(base_url('login'));
        }
        

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

        // Contar por estado (en_camino, entregado y cancelado)
        $estadisticas = [];
        $estados_colores = [
            'en_camino' => 'primary',
            'entregado' => 'success',
            'cancelado' => 'danger'
        ];

        foreach ($pedidos_filtrados as $pedido) {
            $estado = $pedido['estado'];
            // Solo incluir estados en_camino, entregado y cancelado
            if (in_array($estado, ['en_camino', 'entregado', 'cancelado'])) {
                if (!isset($estadisticas[$estado])) {
                    $estadisticas[$estado] = [
                        'cantidad' => 0,
                        'color' => $estados_colores[$estado] ?? 'secondary'
                    ];
                }
                $estadisticas[$estado]['cantidad']++;
            }
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
        
        // Total de entregas
        $total_entregas = count(array_filter($pedidos_repartidor, function($pedido) {
            return $pedido['estado'] === 'entregado';
        }));

        $data = [
            'title' => 'Estadísticas de Repartidor',
            'estadisticas' => $estadisticas,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'entregas_hoy' => $entregas_hoy,
            'entregas_semana' => $entregas_semana,
            'tiempo_promedio_entrega' => $tiempo_promedio_entrega,
            'total_entregas' => $total_entregas
        ];
        return view('header', $data)
            . view('navbar_repartidor')
            . view('repartidor/estadisticas')
            . view('footer_repartidor');
    }

    /**
     * Marca el pago de un pedido como recibido por el repartidor
     */
    public function marcarPagoRecibido()
    {
        $repartidor_id = session()->get('user_id');
        
        // Verificar que el usuario esté logueado y sea repartidor
        if (!session()->get('logueado') || session()->get('user_role') !== 'repartidor') {
            return $this->response->setStatusCode(401)->setJSON(['success' => false, 'message' => 'No autorizado']);
        }
        
        // Obtener datos del JSON
        $jsonData = $this->request->getJSON();
        $pedido_id = $jsonData->pedido_id ?? null;
        
        if (!$pedido_id) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'ID de pedido requerido']);
        }

        try {
            $pedido = $this->pedidoModel->find($pedido_id);
            
            if (!$pedido) {
                return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Pedido no encontrado']);
            }

            // Verificar que el pedido esté asignado al repartidor actual
            if ($pedido['repartidor_id'] != $repartidor_id) {
                return $this->response->setStatusCode(403)->setJSON(['success' => false, 'message' => 'No tienes permisos para este pedido']);
            }

            // Verificar que el pago esté pendiente y sea en efectivo
            if ($pedido['estado_pago'] != 'pendiente' || $pedido['metodo_pago'] != 'efectivo') {
                return $this->response->setStatusCode(400)->setJSON([
                    'success' => false, 
                    'message' => 'El pago no está pendiente o no es en efectivo',
                    'debug' => [
                        'estado_pago' => $pedido['estado_pago'],
                        'metodo_pago' => $pedido['metodo_pago']
                    ]
                ]);
            }

            // Marcar como pagado
            $resultado = $this->pedidoModel->update($pedido_id, ['estado_pago' => 'pagado']);
            
            if ($resultado) {
                return $this->response->setJSON(['success' => true, 'message' => 'Pago marcado como recibido']);
            } else {
                return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Error al actualizar el estado del pago']);
            }
        } catch (Exception $e) {
            log_message('error', 'Error en marcarPagoRecibido: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Error interno del servidor']);
        }
    }
} 