<?php
namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;

/**
 * Modelo para la tabla 'combos'.
 * Permite obtener combos activos, detalle de combo y productos en combo.
 */
class ComboModel extends Model
{
    protected $table = 'combos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre', 'descripcion', 'precio', 'imagen', 'activo', 'fecha_creacion'
    ];

    /**
     * Obtiene todos los combos activos.
     * @return array
     */
    public function getAllActivos(): array
    {
        return $this->where('activo', 1)
                    ->orderBy('nombre', 'asc')
                    ->findAll();
    }

    /**
     * Obtiene el detalle de un combo por su ID (si está activo).
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
     * Obtiene los productos que componen un combo, incluyendo cantidad.
     * @param int $combo_id
     * @return array
     */
    public function getProductosEnCombo(int $combo_id): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('productos_en_combos pec');
        $builder->select('pec.producto_id, p.nombre, p.descripcion, p.precio, p.imagen, pec.cantidad');
        $builder->join('productos p', 'pec.producto_id = p.id');
        $builder->where('pec.combo_id', $combo_id);
        $builder->where('p.activo', 1);
        return $builder->get()->getResultArray();
    }

    /**
     * Obtiene combos con información de productos.
     * @return array
     */
    public function getCombosConProductos(): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('combos c');
        $builder->select('c.*, GROUP_CONCAT(p.nombre) as productos');
        $builder->join('productos_en_combos pec', 'c.id = pec.combo_id');
        $builder->join('productos p', 'pec.producto_id = p.id');
        $builder->where('c.activo', 1);
        $builder->where('p.activo', 1);
        $builder->groupBy('c.id');
        $builder->orderBy('c.nombre', 'asc');
        return $builder->get()->getResultArray();
    }

    /**
     * Calcula el precio total de los productos en un combo.
     * @param int $combo_id
     * @return float
     */
    public function calcularPrecioProductos(int $combo_id): float
    {
        $productos = $this->getProductosEnCombo($combo_id);
        $total = 0;
        
        foreach ($productos as $producto) {
            $total += $producto['precio'] * $producto['cantidad'];
        }
        
        return $total;
    }

    /**
     * Obtiene el ahorro de un combo comparado con comprar productos por separado.
     * @param int $combo_id
     * @return float
     */
    public function getAhorroCombo(int $combo_id): float
    {
        $combo = $this->getById($combo_id);
        if (!$combo) {
            return 0;
        }
        
        $precioProductos = $this->calcularPrecioProductos($combo_id);
        $precioCombo = $combo['precio'];
        
        return $precioProductos - $precioCombo;
    }
} 