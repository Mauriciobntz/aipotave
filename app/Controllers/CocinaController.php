<?php
namespace App\Controllers;

use App\Models\PedidoModel;
use App\Models\DetallePedidoModel;
use App\Models\HistorialEstadosModel;
use App\Controllers\NotificacionController;
use CodeIgniter\Controller;

/**
 * Controlador para el panel de cocina.
 */
class CocinaController extends Controller
{
    protected $pedidoModel;
    protected $detalleModel;
    protected $historialModel;
    protected $notificacionController;

    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
        $this->detalleModel = new DetallePedidoModel();
        $this->historialModel = new HistorialEstadosModel();
        $this->notificacionController = new NotificacionController();
    }

    /**
     * Muestra el listado de pedidos en preparación o confirmados.
     */
    public function pedidos()
    {
        // Obtener filtros de la URL
        $estado_filtro = $this->request->getGet('estado') ?? '';
        $fecha_desde = $this->request->getGet('fecha_desde') ?? '';
        $fecha_hasta = $this->request->getGet('fecha_hasta') ?? '';
        $orden = $this->request->getGet('orden') ?? 'fecha_desc';
        
        $pedidos = $this->pedidoModel->getPedidosConRepartidor();
        
        // Aplicar filtros
        $pedidos_filtrados = array_filter($pedidos, function($pedido) use ($estado_filtro, $fecha_desde, $fecha_hasta) {
            // Filtro por estado
            if ($estado_filtro && $pedido['estado'] !== $estado_filtro) {
                return false;
            }
            
            // Filtro por fecha desde
            if ($fecha_desde && date('Y-m-d', strtotime($pedido['fecha'])) < $fecha_desde) {
                return false;
            }
            
            // Filtro por fecha hasta
            if ($fecha_hasta && date('Y-m-d', strtotime($pedido['fecha'])) > $fecha_hasta) {
                return false;
            }
            
            // Solo mostrar pedidos relevantes para cocina
            return in_array($pedido['estado'], ['confirmado', 'en_preparacion', 'listo']);
        });
        
        // Aplicar ordenamiento
        usort($pedidos_filtrados, function($a, $b) use ($orden) {
            switch ($orden) {
                case 'fecha_asc':
                    return strtotime($a['fecha']) - strtotime($b['fecha']);
                case 'fecha_desc':
                    return strtotime($b['fecha']) - strtotime($a['fecha']);
                case 'prioridad':
                    // Ordenar por prioridad (pendiente primero, luego en_preparacion, luego listo)
                    $prioridad = ['pendiente' => 1, 'en_preparacion' => 2, 'listo' => 3];
                    $prioridadA = $prioridad[$a['estado']] ?? 4;
                    $prioridadB = $prioridad[$b['estado']] ?? 4;
                    return $prioridadA - $prioridadB;
                default:
                    return strtotime($b['fecha']) - strtotime($a['fecha']);
            }
        });
        
        $data = [
            'title' => 'Pedidos en Cocina',
            'pedidos' => array_values($pedidos_filtrados), // Reindexar array
            'estado_filtro' => $estado_filtro,
            'fecha_desde' => $fecha_desde,
            'fecha_hasta' => $fecha_hasta,
            'orden' => $orden
        ];
        return view('header', $data)
            . view('navbar')
            . view('cocina/pedidos')
            . view('footer_cocina');
    }

    /**
     * Muestra el detalle de un pedido para la cocina.
     * @param int $id
     */
    public function detalle($id)
    {
        $pedido = $this->pedidoModel->getById($id);
        if (!$pedido) {
            return redirect()->to(base_url('cocina/pedidos'))->with('error', 'Pedido no encontrado.');
        }
        
        $detalles = $this->detalleModel->getDetallesConInfo($id);
        $historial = $this->historialModel->getByPedidoId($id);
        
        $data = [
            'title' => 'Detalle de Pedido en Cocina',
            'pedido' => $pedido,
            'detalles' => $detalles,
            'historial' => $historial
        ];
        return view('header', $data)
            . view('navbar')
            . view('cocina/pedido_detalle')
            . view('footer_cocina');
    }

    /**
     * Cambia el estado de un pedido desde la cocina.
     * @param int $id
     */
    public function cambiarEstado($id)
    {
        $nuevo_estado = $this->request->getPost('estado');
        $observaciones = $this->request->getPost('observaciones') ?? '';
        
        // Si es una petición JSON, obtener el estado del body
        if ($this->request->getHeaderLine('Content-Type') === 'application/json') {
            $jsonData = json_decode($this->request->getBody(), true);
            $nuevo_estado = $jsonData['estado'] ?? '';
            $observaciones = $jsonData['observaciones'] ?? '';
        }
        
        if (!in_array($nuevo_estado, ['confirmado', 'en_preparacion', 'listo', 'en_camino', 'entregado', 'cancelado'])) {
            if ($this->request->getHeaderLine('Content-Type') === 'application/json') {
                return $this->response->setJSON(['success' => false, 'message' => 'Estado no válido']);
            }
            return redirect()->back()->with('error', 'Estado no válido');
        }

        $pedido = $this->pedidoModel->find($id);
        if (!$pedido) {
            if ($this->request->getHeaderLine('Content-Type') === 'application/json') {
                return $this->response->setJSON(['success' => false, 'message' => 'Pedido no encontrado']);
            }
            return redirect()->back()->with('error', 'Pedido no encontrado');
        }

        $estado_anterior = $pedido['estado'];
        
        // Actualizar el pedido con el nuevo estado y observaciones
        $datos_actualizacion = ['estado' => $nuevo_estado];
        if (!empty($observaciones)) {
            $datos_actualizacion['observaciones'] = $pedido['observaciones'] ? $pedido['observaciones'] . "\n" . $observaciones : $observaciones;
        }
        
        if ($this->pedidoModel->update($id, $datos_actualizacion)) {
            // Registrar el cambio en el historial
            $this->historialModel->insert([
                'pedido_id' => $id,
                'estado_anterior' => $estado_anterior,
                'estado_nuevo' => $nuevo_estado,
                'observaciones' => $observaciones,
                'usuario_id' => session('user_id'),
                'fecha' => date('Y-m-d H:i:s')
            ]);
            
            // Enviar notificación al cliente
            $this->notificacionController->enviarNotificacionEstado($id, $nuevo_estado);
            
            if ($this->request->getHeaderLine('Content-Type') === 'application/json') {
                return $this->response->setJSON(['success' => true, 'message' => 'Estado actualizado correctamente']);
            }
            return redirect()->back()->with('success', 'Estado del pedido actualizado correctamente');
        } else {
            if ($this->request->getHeaderLine('Content-Type') === 'application/json') {
                return $this->response->setJSON(['success' => false, 'message' => 'Error al actualizar el estado']);
            }
            return redirect()->back()->with('error', 'Error al actualizar el estado del pedido');
        }
    }

    /**
     * Muestra estadísticas de la cocina
     */
    public function estadisticas()
    {
        $fecha_inicio = $this->request->getGet('fecha_inicio') ?? date('Y-m-d', strtotime('-7 days'));
        $fecha_fin = $this->request->getGet('fecha_fin') ?? date('Y-m-d');

        // Obtener estadísticas de pedidos por estado
        $pedidos = $this->pedidoModel->getPedidosConRepartidor();
        $pedidos_filtrados = array_filter($pedidos, function($pedido) use ($fecha_inicio, $fecha_fin) {
            $fecha_pedido = date('Y-m-d', strtotime($pedido['fecha']));
            return $fecha_pedido >= $fecha_inicio && $fecha_pedido <= $fecha_fin;
        });

        // Contar por estado
        $estadisticas = [];
        $estados_colores = [
            'pendiente' => 'warning',
            'en_preparacion' => 'info',
            'listo' => 'success',
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

        // Calcular tiempo promedio de preparación (simulado)
        $tiempo_promedio_preparacion = 25; // minutos
        
        // Contar pedidos completados hoy
        $pedidos_completados_hoy = count(array_filter($pedidos, function($pedido) {
            return $pedido['estado'] === 'entregado' && 
                   date('Y-m-d', strtotime($pedido['fecha'])) === date('Y-m-d');
        }));
        
        $data = [
            'title' => 'Estadísticas de Cocina',
            'estadisticas' => $estadisticas,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'tiempo_promedio_preparacion' => $tiempo_promedio_preparacion,
            'pedidos_completados_hoy' => $pedidos_completados_hoy
        ];
        return view('header', $data)
            . view('navbar')
            . view('cocina/estadisticas')
            . view('footer_cocina');
    }

    /**
     * Muestra la lista de productos para que cocina pueda gestionar su estado
     */
    public function productos()
    {
        // Obtener filtros de la URL
        $categoria_filtro = $this->request->getGet('categoria') ?? '';
        $estado_filtro = $this->request->getGet('estado') ?? '';
        $busqueda = $this->request->getGet('busqueda') ?? '';
        
        // Obtener productos
        $productoModel = new \App\Models\ProductoModel();
        $categoriaModel = new \App\Models\CategoriaModel();
        $subcategoriaModel = new \App\Models\SubcategoriaModel();
        
        $productos = $productoModel->getProductosConSubcategoria();
        $categorias = $categoriaModel->findAll();
        $subcategorias = $subcategoriaModel->findAll();
        
        // Aplicar filtros
        if (!empty($categoria_filtro)) {
            $productos = array_filter($productos, function($producto) use ($categoria_filtro) {
                return $producto['categoria_id'] == $categoria_filtro;
            });
        }
        
        if (!empty($estado_filtro)) {
            $productos = array_filter($productos, function($producto) use ($estado_filtro) {
                return $producto['activo'] == ($estado_filtro == 'activo' ? 1 : 0);
            });
        }
        
        if (!empty($busqueda)) {
            $productos = array_filter($productos, function($producto) use ($busqueda) {
                return stripos($producto['nombre'], $busqueda) !== false ||
                       stripos($producto['descripcion'], $busqueda) !== false;
            });
        }
        
        $data = [
            'title' => 'Gestionar Productos',
            'productos' => $productos,
            'categorias' => $categorias,
            'subcategorias' => $subcategorias,
            'categoria_filtro' => $categoria_filtro,
            'estado_filtro' => $estado_filtro,
            'busqueda' => $busqueda
        ];
        return view('header', $data)
            . view('navbar')
            . view('cocina/productos')
            . view('footer_cocina');
    }

    /**
     * Cambia el estado de un producto (activo/inactivo)
     * @param int $id
     */
    public function cambiarEstadoProducto($id)
    {
        $productoModel = new \App\Models\ProductoModel();
        
        $producto = $productoModel->find($id);
        if (!$producto) {
            if ($this->request->getHeaderLine('Content-Type') === 'application/json') {
                return $this->response->setJSON(['success' => false, 'message' => 'Producto no encontrado']);
            }
            return redirect()->back()->with('error', 'Producto no encontrado');
        }
        
        $nuevo_estado = $producto['activo'] == 1 ? 0 : 1;
        $estado_texto = $nuevo_estado == 1 ? 'activado' : 'desactivado';
        
        if ($productoModel->update($id, ['activo' => $nuevo_estado])) {
            if ($this->request->getHeaderLine('Content-Type') === 'application/json') {
                return $this->response->setJSON([
                    'success' => true, 
                    'message' => 'Producto ' . $estado_texto . ' correctamente',
                    'nuevo_estado' => $nuevo_estado
                ]);
            }
            return redirect()->back()->with('success', 'Producto ' . $estado_texto . ' correctamente');
        } else {
            if ($this->request->getHeaderLine('Content-Type') === 'application/json') {
                return $this->response->setJSON(['success' => false, 'message' => 'Error al cambiar el estado del producto']);
            }
            return redirect()->back()->with('error', 'Error al cambiar el estado del producto');
        }
    }

    /**
     * Desactiva todos los productos de una categoría específica
     * @param int $categoria_id
     */
    public function desactivarProductosCategoria($categoria_id)
    {
        $productoModel = new \App\Models\ProductoModel();
        $subcategoriaModel = new \App\Models\SubcategoriaModel();
        
        // Obtener todas las subcategorías de esta categoría
        $subcategorias = $subcategoriaModel->where('categoria_id', $categoria_id)->findAll();
        $subcategoria_ids = array_column($subcategorias, 'id');
        
        // Desactivar todos los productos de estas subcategorías
        $productos_afectados = 0;
        if (!empty($subcategoria_ids)) {
            $productos = $productoModel->whereIn('subcategoria_id', $subcategoria_ids)
                                      ->where('activo', 1)
                                      ->findAll();
            
            foreach ($productos as $producto) {
                if ($productoModel->update($producto['id'], ['activo' => 0])) {
                    $productos_afectados++;
                }
            }
        }
        
        if ($this->request->getHeaderLine('Content-Type') === 'application/json') {
            return $this->response->setJSON([
                'success' => true,
                'message' => "Se desactivaron {$productos_afectados} productos de la categoría",
                'productos_afectados' => $productos_afectados
            ]);
        }
        return redirect()->back()->with('success', "Se desactivaron {$productos_afectados} productos de la categoría");
    }

    /**
     * Desactiva todos los productos de una subcategoría específica
     * @param int $subcategoria_id
     */
    public function desactivarProductosSubcategoria($subcategoria_id)
    {
        $productoModel = new \App\Models\ProductoModel();
        
        // Desactivar todos los productos de esta subcategoría
        $productos = $productoModel->where('subcategoria_id', $subcategoria_id)
                                  ->where('activo', 1)
                                  ->findAll();
        
        $productos_afectados = 0;
        foreach ($productos as $producto) {
            if ($productoModel->update($producto['id'], ['activo' => 0])) {
                $productos_afectados++;
            }
        }
        
        if ($this->request->getHeaderLine('Content-Type') === 'application/json') {
            return $this->response->setJSON([
                'success' => true,
                'message' => "Se desactivaron {$productos_afectados} productos de la subcategoría",
                'productos_afectados' => $productos_afectados
            ]);
        }
        return redirect()->back()->with('success', "Se desactivaron {$productos_afectados} productos de la subcategoría");
    }

    /**
     * Muestra la pantalla de cocina para visualización en pantalla grande.
     */
    public function pantalla()
    {
        // Obtener solo pedidos relevantes para cocina (confirmados, en preparación, listos)
        $pedidos = $this->pedidoModel->getPedidosConRepartidor();
        
        $pedidos_filtrados = array_filter($pedidos, function($pedido) {
            return in_array($pedido['estado'], ['confirmado', 'en_preparacion', 'listo']);
        });
        
        // Ordenar por prioridad y fecha
        usort($pedidos_filtrados, function($a, $b) {
            // Prioridad: confirmado > en_preparacion > listo
            $prioridad = ['confirmado' => 1, 'en_preparacion' => 2, 'listo' => 3];
            $prioridadA = $prioridad[$a['estado']] ?? 4;
            $prioridadB = $prioridad[$b['estado']] ?? 4;
            
            if ($prioridadA !== $prioridadB) {
                return $prioridadA - $prioridadB;
            }
            
            // Si misma prioridad, ordenar por fecha (más reciente primero)
            return strtotime($b['fecha']) - strtotime($a['fecha']);
        });
        
        // Obtener detalles de cada pedido
        foreach ($pedidos_filtrados as &$pedido) {
            $pedido['detalles'] = $this->detalleModel->getDetallesConInfo($pedido['id']);
        }
        
        $data = [
            'title' => 'Pantalla de Cocina',
            'pedidos' => array_values($pedidos_filtrados),
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        return view('cocina/pantalla', $data);
    }
} 