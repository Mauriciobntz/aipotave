<?php

namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\ComboModel;
use App\Models\CategoriaModel;

class Home extends BaseController
{
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

        $data = [
            'title' => 'Menú principal | Mi Restaurante',
            'categoriasConProductos' => $categoriasConProductos,
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
     * Método temporal para actualizar las categorías de los productos
     */
    public function actualizarCategorias()
    {
        try {
            $db = \Config\Database::connect();
            
            echo "<h2>Verificando categorías existentes...</h2>";
            
            // Verificar categorías existentes
            $result = $db->query("SELECT id, nombre, descripcion, activo FROM categorias ORDER BY id");
            $categorias = $result->getResultArray();
            
            echo "<h3>Categorías en la base de datos:</h3>";
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Activo</th></tr>";
            foreach ($categorias as $categoria) {
                echo "<tr>";
                echo "<td>" . $categoria['id'] . "</td>";
                echo "<td>" . htmlspecialchars($categoria['nombre']) . "</td>";
                echo "<td>" . htmlspecialchars($categoria['descripcion']) . "</td>";
                echo "<td>" . ($categoria['activo'] ? 'Sí' : 'No') . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            echo "<h3>Productos con sus categorías:</h3>";
            $result = $db->query("SELECT p.id, p.nombre, p.tipo, p.categoria_id, c.nombre as categoria_nombre 
                                 FROM productos p 
                                 LEFT JOIN categorias c ON p.categoria_id = c.id 
                                 ORDER BY p.id");
            $productos = $result->getResultArray();
            
            echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>ID</th><th>Nombre</th><th>Tipo</th><th>Categoría ID</th><th>Nombre Categoría</th></tr>";
            foreach ($productos as $producto) {
                echo "<tr>";
                echo "<td>" . $producto['id'] . "</td>";
                echo "<td>" . htmlspecialchars($producto['nombre']) . "</td>";
                echo "<td>" . $producto['tipo'] . "</td>";
                echo "<td>" . ($producto['categoria_id'] ?? 'NULL') . "</td>";
                echo "<td>" . htmlspecialchars($producto['categoria_nombre'] ?? 'Sin categoría') . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            echo "<h3>Prueba del modelo de categorías:</h3>";
            $categoriaModel = new \App\Models\CategoriaModel();
            $categoriasConProductos = $categoriaModel->getCategoriasConProductos();
            
            echo "<p>Número de categorías con productos: " . count($categoriasConProductos) . "</p>";
            foreach ($categoriasConProductos as $categoria) {
                echo "<h4>Categoría: " . htmlspecialchars($categoria['nombre']) . " (ID: " . $categoria['id'] . ")</h4>";
                echo "<p>Productos: " . count($categoria['productos']) . "</p>";
                if (!empty($categoria['productos'])) {
                    echo "<ul>";
                    foreach ($categoria['productos'] as $producto) {
                        echo "<li>" . htmlspecialchars($producto['nombre']) . " - $" . $producto['precio'] . "</li>";
                    }
                    echo "</ul>";
                }
            }
            
            echo "<p><a href='" . base_url() . "'>Volver al inicio</a></p>";
            
        } catch (Exception $e) {
            echo "<h2>Error:</h2>";
            echo "<p>" . $e->getMessage() . "</p>";
            echo "<p><a href='" . base_url() . "'>Volver al inicio</a></p>";
        }
    }
}
