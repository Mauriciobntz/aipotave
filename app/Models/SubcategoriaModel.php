<?php
namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para la tabla 'subcategorias'.
 * Permite gestionar las subcategorías de productos.
 */
class SubcategoriaModel extends Model
{
    protected $table = 'subcategorias';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'descripcion', 'categoria_id', 'activo'];

    /**
     * Obtiene todas las subcategorías activas.
     * @return array
     */
    public function getAllActivas(): array
    {
        return $this->where('activo', 1)
                    ->orderBy('nombre', 'asc')
                    ->findAll();
    }

    /**
     * Obtiene subcategorías por categoría.
     * @param int $categoria_id
     * @return array
     */
    public function getByCategoria(int $categoria_id): array
    {
        return $this->where('categoria_id', $categoria_id)
                    ->where('activo', 1)
                    ->orderBy('nombre', 'asc')
                    ->findAll();
    }

    /**
     * Obtiene una subcategoría por ID.
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
     * Obtiene subcategorías con información de categoría y contador de productos.
     * @return array
     */
    public function getSubcategoriasConCategoria(): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('subcategorias s');
        $builder->select('s.*, c.nombre as categoria_nombre, COUNT(p.id) as productos_count');
        $builder->join('categorias c', 's.categoria_id = c.id');
        $builder->join('productos p', 's.id = p.subcategoria_id AND p.activo = 1', 'left');
        $builder->where('s.activo', 1);
        $builder->where('c.activo', 1);
        $builder->groupBy('s.id');
        $builder->orderBy('c.nombre', 'asc');
        $builder->orderBy('s.nombre', 'asc');
        return $builder->get()->getResultArray();
    }
} 