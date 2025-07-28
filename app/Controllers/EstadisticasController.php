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

        $data = [
            'title' => 'Estadísticas y Reportes',
            'totalVentas' => $totalVentas,
            'cantidadPedidos' => $cantidadPedidos,
            'ganancias' => $ganancias,
            'productosMasPedidos' => $productosMasPedidos,
            'desde' => $desde,
            'hasta' => $hasta,
            'producto_id' => $producto_id,
            'productos' => $productos,
            'repartidor_id' => $repartidor_id,
            'repartidores' => $repartidores,
            'ventasPorDia' => $ventasPorDia
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