<?php
namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para la tabla 'categorias'.
 * Permite gestionar las categorías de productos.
 */
class CategoriaModel extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'descripcion', 'activo', 'orden'];

    /**
     * Obtiene todas las categorías activas.
     * @return array
     */
    public function getAllActivas(): array
    {
        return $this->where('activo', 1)
                    ->orderBy('orden', 'asc')
                    ->orderBy('nombre', 'asc')
                    ->findAll();
    }

    /**
     * Obtiene una categoría por ID.
     * @param int $id
     * @return array|null
     */
    public function getById(int $id): ?array
    {
        return $this->where('id', $id)
                    ->where('activo', 1)
                    ->first();
    }

    /**
     * Obtiene categorías con sus subcategorías y contadores.
     * @return array
     */
    public function getCategoriasConSubcategorias(): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('categorias c');
        $builder->select('c.*, 
                         COUNT(DISTINCT s.id) as subcategorias_count,
                         COUNT(DISTINCT p.id) as productos_count');
        $builder->join('subcategorias s', 'c.id = s.categoria_id AND s.activo = 1', 'left');
        $builder->join('productos p', 's.id = p.subcategoria_id AND p.activo = 1', 'left');
        $builder->where('c.activo', 1);
        $builder->groupBy('c.id');
        $builder->orderBy('c.orden', 'asc');
        $builder->orderBy('c.nombre', 'asc');
        return $builder->get()->getResultArray();
    }

    /**
     * Obtiene todas las categorías con sus productos asociados.
     * @return array
     */
    public function getCategoriasConProductos(): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('categorias c');
        $builder->select('c.*, 
                         p.id as producto_id,
                         p.nombre as producto_nombre,
                         p.descripcion as producto_descripcion,
                         p.precio as producto_precio,
                         p.imagen as producto_imagen,
                         p.tipo as producto_tipo,
                         p.activo as producto_activo');
        $builder->join('productos p', 'c.id = p.categoria_id AND p.activo = 1', 'left');
        $builder->where('c.activo', 1);
        $builder->orderBy('c.orden', 'asc');
        $builder->orderBy('c.nombre', 'asc');
        $builder->orderBy('p.nombre', 'asc');
        
        $result = $builder->get()->getResultArray();
        
        // Agrupar productos por categoría
        $categorias = [];
        foreach ($result as $row) {
            $categoriaId = $row['id'];
            
            if (!isset($categorias[$categoriaId])) {
                $categorias[$categoriaId] = [
                    'id' => $row['id'],
                    'nombre' => $row['nombre'],
                    'descripcion' => $row['descripcion'],
                    'activo' => $row['activo'],
                    'productos' => []
                ];
            }
            
            // Solo agregar productos si existe un producto_id
            if ($row['producto_id']) {
                $categorias[$categoriaId]['productos'][] = [
                    'id' => $row['producto_id'],
                    'nombre' => $row['producto_nombre'],
                    'descripcion' => $row['producto_descripcion'],
                    'precio' => $row['producto_precio'],
                    'imagen' => $row['producto_imagen'],
                    'tipo' => $row['producto_tipo'],
                    'activo' => $row['producto_activo']
                ];
            }
        }
        
        return array_values($categorias);
    }

    /**
     * Obtiene una categoría específica con sus productos.
     * @param int $categoriaId
     * @return array|null
     */
    public function getCategoriaConProductos(int $categoriaId): ?array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('categorias c');
        $builder->select('c.*, 
                         p.id as producto_id,
                         p.nombre as producto_nombre,
                         p.descripcion as producto_descripcion,
                         p.precio as producto_precio,
                         p.imagen as producto_imagen,
                         p.tipo as producto_tipo,
                         p.activo as producto_activo');
        $builder->join('productos p', 'c.id = p.categoria_id AND p.activo = 1', 'left');
        $builder->where('c.id', $categoriaId);
        $builder->where('c.activo', 1);
        $builder->orderBy('p.nombre', 'asc');
        
        $result = $builder->get()->getResultArray();
        
        if (empty($result)) {
            return null;
        }
        
        // Construir la categoría con sus productos
        $categoria = [
            'id' => $result[0]['id'],
            'nombre' => $result[0]['nombre'],
            'descripcion' => $result[0]['descripcion'],
            'activo' => $result[0]['activo'],
            'productos' => []
        ];
        
        foreach ($result as $row) {
            if ($row['producto_id']) {
                $categoria['productos'][] = [
                    'id' => $row['producto_id'],
                    'nombre' => $row['producto_nombre'],
                    'descripcion' => $row['producto_descripcion'],
                    'precio' => $row['producto_precio'],
                    'imagen' => $row['producto_imagen'],
                    'tipo' => $row['producto_tipo'],
                    'activo' => $row['producto_activo']
                ];
            }
        }
        
        return $categoria;
    }
} 