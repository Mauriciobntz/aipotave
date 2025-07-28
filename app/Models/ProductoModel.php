<?php
namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para la tabla 'productos'.
 * Permite obtener productos activos, por tipo y por ID.
 */
class ProductoModel extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre', 'descripcion', 'precio', 'imagen', 'tipo', 'subcategoria_id', 'subcategoria', 'activo', 'fecha_creacion'
    ];

    /**
     * Obtiene todos los productos activos.
     * @return array
     */
    public function getAllActivos(): array
    {
        return $this->where('activo', 1)
                    ->orderBy('nombre', 'asc')
                    ->findAll();
    }

    /**
     * Obtiene productos activos filtrados por tipo (comida, bebida, vianda).
     * @param string $tipo
     * @return array
     */
    public function getByTipo(string $tipo): array
    {
        return $this->where('activo', 1)
                    ->where('tipo', $tipo)
                    ->orderBy('nombre', 'asc')
                    ->findAll();
    }

    /**
     * Obtiene productos activos filtrados por subcategoría.
     * @param int $subcategoria_id
     * @return array
     */
    public function getBySubcategoria(int $subcategoria_id): array
    {
        return $this->where('activo', 1)
                    ->where('subcategoria_id', $subcategoria_id)
                    ->orderBy('nombre', 'asc')
                    ->findAll();
    }

    /**
     * Obtiene el detalle de un producto por su ID (si está activo).
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
     * Obtiene productos con información de subcategoría.
     * @param string $tipo
     * @return array
     */
    public function getProductosConSubcategoria(string $tipo = null): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('productos p');
        $builder->select('p.*, s.nombre as subcategoria_nombre, c.nombre as categoria_nombre, c.id as categoria_id');
        $builder->join('subcategorias s', 'p.subcategoria_id = s.id', 'left');
        $builder->join('categorias c', 's.categoria_id = c.id', 'left');
        
        // No filtrar por activo para permitir ver todos los productos
        // $builder->where('p.activo', 1);
        
        if ($tipo) {
            $builder->where('p.tipo', $tipo);
        }
        
        $builder->orderBy('p.nombre', 'asc');
        return $builder->get()->getResultArray();
    }
} 