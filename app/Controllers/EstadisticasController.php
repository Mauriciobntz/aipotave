<?php
namespace App\Controllers;

use App\Models\PedidoModel;
use App\Models\DetallePedidoModel;
use CodeIgniter\Controller;

/**
 * Controlador para el dashboard de estadísticas y reportes.
 */
class EstadisticasController extends Controller
{
    /**
     * Muestra el dashboard de estadísticas generales.
     */
    public function dashboard()
    {
        $pedidoModel = new PedidoModel();
        $detalleModel = new DetallePedidoModel();
        $productoModel = new \App\Models\ProductoModel();
        $productos = $productoModel->getAllActivos();
        $repartidorModel = new \App\Models\RepartidorModel();
        $repartidores = $repartidorModel->listarActivos();
        $repartidor_id = $this->request->getGet('repartidor_id');

        // Filtros por fecha, producto y repartidor
        $desde = $this->request->getGet('desde');
        $hasta = $this->request->getGet('hasta');
        $producto_id = $this->request->getGet('producto_id');
        $where = [];
        if ($desde) {
            $where['fecha >='] = $desde . ' 00:00:00';
        }
        if ($hasta) {
            $where['fecha <='] = $hasta . ' 23:59:59';
        }
        if ($repartidor_id) {
            $where['repartidor_id'] = $repartidor_id;
        }
        $pedidos = empty($where) ? $pedidoModel->findAll() : $pedidoModel->where($where)->findAll();
        $totalVentas = 0;
        $cantidadPedidos = count($pedidos);
        $idsPedidos = [];
        foreach ($pedidos as $p) {
            $totalVentas += $p['total'];
            $idsPedidos[] = $p['id'];
        }

        // Productos más pedidos (solo en pedidos filtrados y producto seleccionado)
        $productosMasPedidos = [];
        if ($idsPedidos) {
            $db = \Config\Database::connect();
            $idsStr = implode(',', $idsPedidos);
            $whereProducto = $producto_id ? 'AND producto_id = ' . intval($producto_id) : '';
            $productosMasPedidos = $db->query('
                SELECT producto_id, COUNT(*) as cantidad, SUM(cantidad) as total_cant
                FROM detalles_pedido
                WHERE producto_id IS NOT NULL ' . $whereProducto . ' AND pedido_id IN (' . $idsStr . ')
                GROUP BY producto_id
                ORDER BY total_cant DESC
                LIMIT 5
            ')->getResultArray();
        }

        // Procesar datos de productos para la vista
        $top_productos = [];
        $total_ventas_productos = 0;
        
        foreach ($productosMasPedidos as $prod) {
            $producto = $productoModel->getById($prod['producto_id']);
            if ($producto) {
                $total_ventas_productos += $prod['total_cant'] * $producto['precio'];
                $top_productos[] = [
                    'id' => $prod['producto_id'],
                    'nombre' => $producto['nombre'],
                    'descripcion' => $producto['descripcion'] ?? '',
                    'imagen' => $producto['imagen'] ?? '',
                    'cantidad_vendida' => $prod['total_cant'],
                    'total_ventas' => $prod['total_cant'] * $producto['precio'],
                    'porcentaje' => 0, // Se calculará después
                    'tendencia' => 0 // Se puede implementar después
                ];
            }
        }
        
        // Calcular porcentajes
        if ($total_ventas_productos > 0) {
            foreach ($top_productos as &$prod) {
                $prod['porcentaje'] = ($prod['total_ventas'] / $total_ventas_productos) * 100;
            }
        }

        $ganancias = $totalVentas;

        // Ventas por día (para gráfico)
        $ventasPorDia = [];
        foreach ($pedidos as $p) {
            $fecha = substr($p['fecha'], 0, 10);
            if (!isset($ventasPorDia[$fecha])) {
                $ventasPorDia[$fecha] = 0;
            }
            $ventasPorDia[$fecha] += $p['total'];
        }
        ksort($ventasPorDia);

        // Calcular métricas adicionales
        $promedio_pedido = $cantidadPedidos > 0 ? round($totalVentas / $cantidadPedidos, 0) : 0;
        
        // Calcular pedidos por día
        $dias_periodo = 1;
        if ($desde && $hasta) {
            $dias_periodo = max(1, (strtotime($hasta) - strtotime($desde)) / (24 * 60 * 60) + 1);
        }
        $pedidos_por_dia = round($cantidadPedidos / $dias_periodo, 1);
        
        // Calcular productos por pedido (simulado)
        $productos_por_pedido = 2.5; // Valor promedio
        
        // Tiempo de entrega promedio (simulado)
        $tiempo_entrega_promedio = 35; // minutos
        
        // Actividad reciente (simulada)
        $actividad_reciente = [
            [
                'titulo' => 'Pedido #' . ($pedidos[0]['codigo_seguimiento'] ?? 'PED123') . ' entregado',
                'fecha' => date('d/m/Y H:i', strtotime($pedidos[0]['fecha'] ?? 'now'))
            ],
            [
                'titulo' => 'Nuevo pedido recibido',
                'fecha' => date('d/m/Y H:i', strtotime('-1 hour'))
            ],
            [
                'titulo' => 'Repartidor asignado a pedido',
                'fecha' => date('d/m/Y H:i', strtotime('-2 hours'))
            ]
        ];
        
        // Preparar datos para gráficos
        $ventas_por_dia_labels = array_keys($ventasPorDia);
        $ventas_por_dia_data = array_values($ventasPorDia);
        
        $productos_labels = array_column($top_productos, 'nombre');
        $productos_data = array_column($top_productos, 'cantidad_vendida');

        $data = [
            'title' => 'Estadísticas y Reportes',
            'ventas_totales' => $totalVentas,
            'total_pedidos' => $cantidadPedidos,
            'ganancias_estimadas' => $ganancias,
            'clientes_unicos' => count(array_unique(array_column($pedidos, 'correo_electronico'))),
            'promedio_pedido' => $promedio_pedido,
            'pedidos_por_dia' => $pedidos_por_dia,
            'productos_por_pedido' => $productos_por_pedido,
            'tiempo_entrega_promedio' => $tiempo_entrega_promedio,
            'actividad_reciente' => $actividad_reciente,
            'top_productos' => $top_productos,
            'desde' => $desde,
            'hasta' => $hasta,
            'fecha_desde' => $desde,
            'fecha_hasta' => $hasta,
            'producto_id' => $producto_id,
            'producto_filtro' => $producto_id,
            'productos' => $productos,
            'repartidor_id' => $repartidor_id,
            'repartidor_filtro' => $repartidor_id,
            'repartidores' => $repartidores,
            'ventasPorDia' => $ventasPorDia,
            'ventas_por_dia_labels' => $ventas_por_dia_labels,
            'ventas_por_dia_data' => $ventas_por_dia_data,
            'productos_labels' => $productos_labels,
            'productos_data' => $productos_data
        ];
        return view('header', $data)
            . view('navbar')
            . view('admin/estadisticas_dashboard')
            . view('footer');
    }

    /**
     * Exporta los productos más pedidos filtrados a un archivo CSV.
     */
    public function exportarExcel()
    {
        $pedidoModel = new \App\Models\PedidoModel();
        $productoModel = new \App\Models\ProductoModel();
        $repartidorModel = new \App\Models\RepartidorModel();

        $desde = $this->request->getGet('desde');
        $hasta = $this->request->getGet('hasta');
        $producto_id = $this->request->getGet('producto_id');
        $repartidor_id = $this->request->getGet('repartidor_id');
        $where = [];
        if ($desde) {
            $where['fecha >='] = $desde . ' 00:00:00';
        }
        if ($hasta) {
            $where['fecha <='] = $hasta . ' 23:59:59';
        }
        if ($repartidor_id) {
            $where['repartidor_id'] = $repartidor_id;
        }
        $pedidos = empty($where) ? $pedidoModel->findAll() : $pedidoModel->where($where)->findAll();
        $idsPedidos = [];
        foreach ($pedidos as $p) {
            $idsPedidos[] = $p['id'];
        }
        $productosMasPedidos = [];
        if ($idsPedidos) {
            $db = \Config\Database::connect();
            $idsStr = implode(',', $idsPedidos);
            $whereProducto = $producto_id ? 'AND producto_id = ' . intval($producto_id) : '';
            $productosMasPedidos = $db->query('
                SELECT producto_id, COUNT(*) as cantidad, SUM(cantidad) as total_cant
                FROM detalles_pedido
                WHERE producto_id IS NOT NULL ' . $whereProducto . ' AND pedido_id IN (' . $idsStr . ')
                GROUP BY producto_id
                ORDER BY total_cant DESC
            ')->getResultArray();
        }

        // Encabezados para descarga CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=estadisticas_productos.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID Producto', 'Nombre', 'Cantidad de pedidos', 'Total de unidades']);
        foreach ($productosMasPedidos as $prod) {
            $nombre = $productoModel->getById($prod['producto_id'])['nombre'] ?? $prod['producto_id'];
            fputcsv($output, [
                $prod['producto_id'],
                $nombre,
                $prod['cantidad'],
                $prod['total_cant']
            ]);
        }
        fclose($output);
        exit;
    }
} 