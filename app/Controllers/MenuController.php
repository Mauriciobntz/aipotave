<?php
namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\ComboModel;
use CodeIgniter\Controller;

/**
 * Controlador para el menú público.
 * Muestra productos, combos y sus detalles.
 */
class MenuController extends Controller
{
    /**
     * Muestra el menú principal con productos y combos activos.
     */
    public function index()
    {
        $productoModel = new ProductoModel();
        $comboModel = new ComboModel();

        // Obtener productos activos agrupados por tipo
        $comidas = $productoModel->getByTipo('comida');
        $bebidas = $productoModel->getByTipo('bebida');
        $viandas = $productoModel->getByTipo('vianda');
        $combos = $comboModel->getAllActivos();

        $data = [
            'title' => 'Menú principal | Mi Restaurante',
            'comidas' => $comidas,
            'bebidas' => $bebidas,
            'viandas' => $viandas,
            'combos' => $combos
        ];

        // Componer las vistas
        return view('header', $data)
            . view('navbar')
            . view('catalogo/productos')
            . view('footer');
    }

    /**
     * Muestra el detalle de un producto específico.
     * @param int $id
     */
    public function producto($id)
    {
        $productoModel = new ProductoModel();
        $producto = $productoModel->getById((int)$id);

        if (!$producto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Producto no encontrado');
        }

        $data = [
            'title' => $producto['nombre'] . ' | Mi Restaurante',
            'producto' => $producto
        ];

        return view('header', $data)
            . view('navbar')
            . view('catalogo/producto_detalle')
            . view('footer');
    }

    /**
     * Muestra el detalle de un combo específico, incluyendo los productos que lo componen.
     * @param int $id
     */
    public function combo($id)
    {
        $comboModel = new ComboModel();
        $combo = $comboModel->getById((int)$id);

        if (!$combo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Combo no encontrado');
        }

        $productos = $comboModel->getProductosEnCombo((int)$id);

        $data = [
            'title' => $combo['nombre'] . ' | Mi Restaurante',
            'combo' => $combo,
            'productos' => $productos
        ];

        return view('header', $data)
            . view('navbar')
            . view('catalogo/combo_detalle')
            . view('footer');
    }
} 