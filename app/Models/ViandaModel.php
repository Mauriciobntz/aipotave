<?php
namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para la gestión de viandas diarias y su stock.
 * Usa la tabla productos (tipo=vianda) y la tabla stock.
 */
class ViandaModel extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre', 'descripcion', 'precio', 'imagen', 'tipo', 'subcategoria_id', 'subcategoria', 'activo', 'fecha_creacion'
    ];

    /**
     * Obtiene todas las viandas activas.
     * @return array
     */
    public function listarViandas(): array
    {
        return $this->where('tipo', 'vianda')
                    ->where('activo', 1)
                    ->orderBy('nombre', 'asc')
                    ->findAll();
    }

    /**
     * Obtiene una vianda por ID.
     * @param int $id
     * @return array|null
     */
    public function getById($id): ?array
    {
        return $this->where('id', $id)
                    ->where('tipo', 'vianda')
                    ->where('activo', 1)
                    ->first();
    }

    /**
     * Obtiene el stock de una vianda para una fecha dada.
     * @param int $vianda_id
     * @param string $fecha (YYYY-MM-DD)
     * @return int
     */
    public function getStock($vianda_id, $fecha): int
    {
        $stockModel = new \App\Models\StockModel();
        return $stockModel->getStock($vianda_id, $fecha);
    }

    /**
     * Actualiza el stock de una vianda para una fecha.
     * @param int $vianda_id
     * @param string $fecha
     * @param int $cantidad
     * @return bool
     */
    public function actualizarStock($vianda_id, $fecha, $cantidad): bool
    {
        $stockModel = new \App\Models\StockModel();
        return $stockModel->actualizarStock($vianda_id, $fecha, $cantidad);
    }

    /**
     * Obtiene viandas con su stock para una fecha específica.
     * @param string $fecha
     * @return array
     */
    public function getViandasConStock(string $fecha): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('productos p');
        $builder->select('p.*, COALESCE(s.cantidad, 0) as stock_disponible');
        $builder->join('stock s', 'p.id = s.producto_id AND s.fecha = "' . $fecha . '"', 'left');
        $builder->where('p.tipo', 'vianda');
        $builder->where('p.activo', 1);
        $builder->orderBy('p.nombre', 'asc');
        return $builder->get()->getResultArray();
    }

    /**
     * Obtiene viandas con stock bajo para una fecha.
     * @param string $fecha
     * @param int $limite
     * @return array
     */
    public function getViandasStockBajo(string $fecha, int $limite = 5): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('productos p');
        $builder->select('p.*, COALESCE(s.cantidad, 0) as stock_disponible');
        $builder->join('stock s', 'p.id = s.producto_id AND s.fecha = "' . $fecha . '"', 'left');
        $builder->where('p.tipo', 'vianda');
        $builder->where('p.activo', 1);
        $builder->where('COALESCE(s.cantidad, 0) <=', $limite);
        $builder->orderBy('stock_disponible', 'asc');
        return $builder->get()->getResultArray();
    }
} 