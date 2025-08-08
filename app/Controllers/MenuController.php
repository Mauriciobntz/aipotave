<?php
namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\ComboModel;
use App\Models\CategoriaModel;
use App\Models\SlideModel;
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
        $categoriaModel = new CategoriaModel();

        // Obtener categorías con sus productos
        $categoriasConProductos = $categoriaModel->getCategoriasConProductos();
        
        // Obtener productos activos agrupados por tipo (para mantener compatibilidad)
        $comidas = $productoModel->getByTipo('comida');
        $bebidas = $productoModel->getByTipo('bebida');
        $viandas = $productoModel->getByTipo('vianda');
        $combos = $comboModel->getAllActivos();

        // Obtener productos destacados (aleatorios para mostrar variedad)
        $productosDestacados = $productoModel->where('activo', 1)
            ->orderBy('RAND()')
            ->findAll(4);

        // Obtener combos destacados
        $combosDestacados = $comboModel->where('activo', 1)
            ->orderBy('RAND()')
            ->findAll(4);

        // Obtener slides activos de la base de datos
        $slideModel = new SlideModel();
        $slides = $slideModel->getSlidesActivos();

        $data = [
            'title' => 'Menú principal | Mi Restaurante',
            'categoriasConProductos' => $categoriasConProductos,
            'comidas' => $comidas,
            'bebidas' => $bebidas,
            'viandas' => $viandas,
            'combos' => $combos,
            'productosDestacados' => $productosDestacados,
            'combosDestacados' => $combosDestacados,
            'slides' => $slides
        ];

        // Componer las vistas
        return view('header', $data)
            . view('navbar')
            . view('catalogo/carrusel_destacados')
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
        $producto = $productoModel->getProductosConSubcategoria();
        
        // Buscar el producto específico en el array
        $producto = array_filter($producto, function($p) use ($id) {
            return $p['id'] == $id;
        });
        
        if (empty($producto)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Producto no encontrado');
        }
        
        $producto = array_values($producto)[0]; // Obtener el primer (y único) elemento

        // Buscar productos relacionados: primero por subcategoría, luego por categoría, luego por tipo
        $productosRelacionados = [];
        if (!empty($producto['subcategoria_id'])) {
            $productosRelacionados = $productoModel->where('subcategoria_id', $producto['subcategoria_id'])
                ->where('id !=', $producto['id'])
                ->where('activo', 1)
                ->orderBy('nombre', 'asc')
                ->findAll(4);
        }
        // Si no hay suficientes, buscar por categoría
        if (count($productosRelacionados) < 4 && !empty($producto['categoria_id'])) {
            $faltan = 4 - count($productosRelacionados);
            $otros = $productoModel->where('categoria_id', $producto['categoria_id'])
                ->where('id !=', $producto['id'])
                ->where('activo', 1)
                ->orderBy('nombre', 'asc')
                ->findAll($faltan);
            $productosRelacionados = array_merge($productosRelacionados, $otros);
        }
        // Si aún faltan, completar por tipo
        if (count($productosRelacionados) < 4) {
            $faltan = 4 - count($productosRelacionados);
            $otros = $productoModel->where('tipo', $producto['tipo'])
                ->where('id !=', $producto['id'])
                ->where('activo', 1)
                ->orderBy('nombre', 'asc')
                ->findAll($faltan);
            $productosRelacionados = array_merge($productosRelacionados, $otros);
        }

        $data = [
            'title' => $producto['nombre'] . ' | Mi Restaurante',
            'producto' => $producto,
            'productosRelacionados' => $productosRelacionados
        ];

        // Si es AJAX, solo la descripción plana
        if ($this->request->isAJAX()) {
            return $this->response->setContentType('text/plain')->setBody($producto['descripcion'] ?? '');
        }

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

        // Obtener combos relacionados (otros combos activos)
        $combosRelacionados = $comboModel->where('activo', 1)
            ->where('id !=', $id)
            ->orderBy('RAND()')
            ->findAll(4);

        $data = [
            'title' => $combo['nombre'] . ' | Mi Restaurante',
            'combo' => $combo,
            'productos' => $productos,
            'combosRelacionados' => $combosRelacionados
        ];

        return view('header', $data)
            . view('navbar')
            . view('catalogo/combo_detalle')
            . view('footer');
    }
} 