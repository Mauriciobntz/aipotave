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
    protected $allowedFields = ['nombre', 'descripcion', 'activo'];

    /**
     * Obtiene todas las categorías activas.
     * @return array
     */
    public function getAllActivas(): array
    {
        return $this->where('activo', 1)
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
        $builder->orderBy('c.nombre', 'asc');
        return $builder->get()->getResultArray();
    }
} 