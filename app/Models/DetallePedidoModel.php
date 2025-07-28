<?php
namespace App\Models;

use CodeIgniter\Model;

class DetallePedidoModel extends Model
{
    protected $table = 'detalles_pedido';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'pedido_id', 'producto_id', 'combo_id', 'cantidad', 'precio_unitario', 'observaciones'
    ];
    protected $returnType = 'array';

    /**
     * Obtener detalles de un pedido específico
     */
    public function getByPedidoId(int $pedido_id): array
    {
        return $this->where('pedido_id', $pedido_id)->findAll();
    }

    /**
     * Obtener detalles con información de productos y combos
     */
    public function getDetallesConInfo(int $pedido_id): array
    {
        $builder = $this->db->table('detalles_pedido dp');
        $builder->select('dp.*, p.nombre as producto_nombre, p.imagen as producto_imagen, c.nombre as combo_nombre, c.imagen as combo_imagen');
        $builder->join('productos p', 'p.id = dp.producto_id', 'left');
        $builder->join('combos c', 'c.id = dp.combo_id', 'left');
        $builder->where('dp.pedido_id', $pedido_id);
        
        return $builder->get()->getResultArray();
    }

    /**
     * Obtener detalles con información completa incluyendo subcategorías
     */
    public function getDetallesCompletos(int $pedido_id): array
    {
        $builder = $this->db->table('detalles_pedido dp');
        $builder->select('dp.*, p.nombre as producto_nombre, p.tipo as producto_tipo, p.subcategoria_id, s.nombre as subcategoria_nombre, c.nombre as combo_nombre');
        $builder->join('productos p', 'p.id = dp.producto_id', 'left');
        $builder->join('subcategorias s', 'p.subcategoria_id = s.id', 'left');
        $builder->join('combos c', 'c.id = dp.combo_id', 'left');
        $builder->where('dp.pedido_id', $pedido_id);
        
        return $builder->get()->getResultArray();
    }

    /**
     * Calcular el total de un pedido
     */
    public function calcularTotalPedido(int $pedido_id): float
    {
        $detalles = $this->where('pedido_id', $pedido_id)->findAll();
        $total = 0;
        
        foreach ($detalles as $detalle) {
            $total += $detalle['precio_unitario'] * $detalle['cantidad'];
        }
        
        return $total;
    }

    /**
     * Obtener estadísticas de productos más vendidos
     */
    public function getProductosMasVendidos(int $limite = 10): array
    {
        $builder = $this->db->table('detalles_pedido dp');
        $builder->select('p.nombre, p.tipo, SUM(dp.cantidad) as total_vendido, SUM(dp.precio_unitario * dp.cantidad) as total_ventas');
        $builder->join('productos p', 'p.id = dp.producto_id');
        $builder->where('dp.producto_id IS NOT NULL');
        $builder->groupBy('dp.producto_id');
        $builder->orderBy('total_vendido', 'desc');
        $builder->limit($limite);
        
        return $builder->get()->getResultArray();
    }

    /**
     * Obtener estadísticas de combos más vendidos
     */
    public function getCombosMasVendidos(int $limite = 10): array
    {
        $builder = $this->db->table('detalles_pedido dp');
        $builder->select('c.nombre, SUM(dp.cantidad) as total_vendido, SUM(dp.precio_unitario * dp.cantidad) as total_ventas');
        $builder->join('combos c', 'c.id = dp.combo_id');
        $builder->where('dp.combo_id IS NOT NULL');
        $builder->groupBy('dp.combo_id');
        $builder->orderBy('total_vendido', 'desc');
        $builder->limit($limite);
        
        return $builder->get()->getResultArray();
    }
} 