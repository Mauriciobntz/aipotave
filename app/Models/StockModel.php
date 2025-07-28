<?php
namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para la tabla 'stock'.
 * Maneja el inventario de productos.
 */
class StockModel extends Model
{
    protected $table = 'stock';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'producto_id', 'fecha', 'cantidad'
    ];

    /**
     * Obtiene el stock actual de un producto.
     * @param int $productoId
     * @return int
     */
    public function getStockActual(int $productoId): int
    {
        $result = $this->where('producto_id', $productoId)
                       ->orderBy('fecha', 'desc')
                       ->first();
        return $result ? (int)$result['cantidad'] : 0;
    }

    /**
     * Actualiza el stock de un producto.
     * @param int $productoId
     * @param int $cantidad
     * @return bool
     */
    public function actualizarStock(int $productoId, int $cantidad): bool
    {
        $fechaActual = date('Y-m-d');
        
        // Verificar si ya existe un registro para hoy
        $stockExistente = $this->where('producto_id', $productoId)
                               ->where('fecha', $fechaActual)
                               ->first();
        
        if ($stockExistente) {
            // Actualizar registro existente
            return $this->update($stockExistente['id'], ['cantidad' => $cantidad]);
        } else {
            // Crear nuevo registro
            return $this->insert([
                'producto_id' => $productoId,
                'fecha' => $fechaActual,
                'cantidad' => $cantidad
            ]);
        }
    }

    /**
     * Reduce el stock de un producto.
     * @param int $productoId
     * @param int $cantidadReducir
     * @return bool
     */
    public function reducirStock(int $productoId, int $cantidadReducir): bool
    {
        $stockActual = $this->getStockActual($productoId);
        $nuevoStock = max(0, $stockActual - $cantidadReducir);
        return $this->actualizarStock($productoId, $nuevoStock);
    }

    /**
     * Aumenta el stock de un producto.
     * @param int $productoId
     * @param int $cantidadAumentar
     * @return bool
     */
    public function aumentarStock(int $productoId, int $cantidadAumentar): bool
    {
        $stockActual = $this->getStockActual($productoId);
        $nuevoStock = $stockActual + $cantidadAumentar;
        return $this->actualizarStock($productoId, $nuevoStock);
    }

    /**
     * Obtiene el historial de stock de un producto.
     * @param int $productoId
     * @param int $dias
     * @return array
     */
    public function getHistorialStock(int $productoId, int $dias = 30): array
    {
        $fechaInicio = date('Y-m-d', strtotime("-{$dias} days"));
        return $this->where('producto_id', $productoId)
                    ->where('fecha >=', $fechaInicio)
                    ->orderBy('fecha', 'asc')
                    ->findAll();
    }

    /**
     * Obtiene productos con stock bajo.
     * @param int $stockMinimo
     * @return array
     */
    public function getProductosStockBajo(int $stockMinimo = 10): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('stock s');
        $builder->select('s.*, p.nombre as producto_nombre, p.precio');
        $builder->join('productos p', 's.producto_id = p.id');
        $builder->where('s.cantidad <=', $stockMinimo);
        $builder->where('s.fecha', date('Y-m-d'));
        $builder->orderBy('s.cantidad', 'asc');
        return $builder->get()->getResultArray();
    }

    /**
     * Obtiene estadísticas de stock.
     * @return array
     */
    public function getEstadisticasStock(): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('stock s');
        $builder->select('p.nombre, s.cantidad, s.fecha');
        $builder->join('productos p', 's.producto_id = p.id');
        $builder->where('s.fecha', date('Y-m-d'));
        $builder->orderBy('s.cantidad', 'asc');
        return $builder->get()->getResultArray();
    }
} 