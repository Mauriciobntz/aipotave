<?php
namespace App\Controllers;

use App\Models\StockModel;
use CodeIgniter\Controller;

class StockController extends Controller
{
    protected $stockModel;
    protected $productoModel;

    public function __construct()
    {
        $this->stockModel = new StockModel();
        $this->productoModel = new ProductoModel();
    }

    /**
     * Lista el stock de todos los productos
     */
    public function listar()
    {
        $fecha = $this->request->getGet('fecha') ?? date('Y-m-d');
        $stock = $this->stockModel->getStockPorFecha($fecha);
        
        $data = [
            'stock' => $stock,
            'fecha' => $fecha
        ];

        return view('admin/stock/listar', $data);
    }

    /**
     * Muestra el formulario para actualizar el stock de un producto
     */
    public function actualizar($producto_id)
    {
        $producto = $this->productoModel->find($producto_id);
        
        if (!$producto) {
            return redirect()->to(base_url('admin/stock/listar'))->with('error', 'Producto no encontrado');
        }

        $fecha = $this->request->getGet('fecha') ?? date('Y-m-d');
        $stock_actual = $this->stockModel->getStock($producto_id, $fecha);
        
        $data = [
            'producto' => $producto,
            'stock_actual' => $stock_actual,
            'fecha' => $fecha
        ];

        return view('admin/stock/formulario', $data);
    }

    /**
     * Guarda el stock de un producto
     */
    public function guardar()
    {
        $request = $this->request->getPost();
        
        $rules = [
            'producto_id' => 'required|integer',
            'fecha' => 'required|valid_date',
            'cantidad' => 'required|integer|greater_than_equal_to[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $producto_id = $request['producto_id'];
        $fecha = $request['fecha'];
        $cantidad = $request['cantidad'];

        // Verificar que el producto existe
        $producto = $this->productoModel->find($producto_id);
        if (!$producto) {
            return redirect()->back()->with('error', 'Producto no encontrado');
        }

        if ($this->stockModel->actualizarStock($producto_id, $fecha, $cantidad)) {
            return redirect()->to(base_url('admin/stock/listar?fecha=' . $fecha))->with('success', 'Stock actualizado correctamente');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar el stock');
        }
    }

    /**
     * Muestra estadísticas de stock
     */
    public function estadisticas()
    {
        $fecha_inicio = $this->request->getGet('fecha_inicio') ?? date('Y-m-d', strtotime('-30 days'));
        $fecha_fin = $this->request->getGet('fecha_fin') ?? date('Y-m-d');

        $estadisticas = $this->stockModel->getEstadisticasStock($fecha_inicio, $fecha_fin);
        $productos_stock_bajo = $this->stockModel->getProductosStockBajo(date('Y-m-d'), 10);
        
        $data = [
            'estadisticas' => $estadisticas,
            'productos_stock_bajo' => $productos_stock_bajo,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin
        ];

        return view('admin/stock/estadisticas', $data);
    }

    /**
     * Reduce el stock de un producto (usado cuando se hace un pedido)
     */
    public function reducirStock($producto_id, $cantidad, $fecha = null)
    {
        if (!$fecha) {
            $fecha = date('Y-m-d');
        }

        $stock_actual = $this->stockModel->getStock($producto_id, $fecha);
        
        if ($stock_actual < $cantidad) {
            return false; // No hay suficiente stock
        }

        return $this->stockModel->reducirStock($producto_id, $fecha, $cantidad);
    }

    /**
     * Obtiene productos con stock bajo
     */
    public function getProductosStockBajo()
    {
        $limite = $this->request->getGet('limite') ?? 10;
        $fecha = $this->request->getGet('fecha') ?? date('Y-m-d');
        
        $productos = $this->stockModel->getProductosStockBajo($fecha, $limite);
        
        return $this->response->setJSON($productos);
    }
} 