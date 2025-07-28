<?php
namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para la tabla 'ofertas'.
 * Maneja las ofertas y descuentos de productos y combos.
 */
class OfertaModel extends Model
{
    protected $table = 'ofertas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tipo', 'referencia_id', 'titulo', 'descripcion', 'descuento_porcentaje', 
        'fecha_inicio', 'fecha_fin', 'activa'
    ];

    /**
     * Obtiene todas las ofertas activas.
     * @return array
     */
    public function getOfertasActivas(): array
    {
        $fechaActual = date('Y-m-d');
        return $this->where('activa', 1)
                    ->where('fecha_inicio <=', $fechaActual)
                    ->where('fecha_fin >=', $fechaActual)
                    ->findAll();
    }

    /**
     * Obtiene ofertas por tipo (producto o combo).
     * @param string $tipo
     * @return array
     */
    public function getByTipo(string $tipo): array
    {
        return $this->where('tipo', $tipo)->findAll();
    }

    /**
     * Obtiene ofertas para un producto específico.
     * @param int $productoId
     * @return array
     */
    public function getOfertasProducto(int $productoId): array
    {
        $fechaActual = date('Y-m-d');
        return $this->where('tipo', 'producto')
                    ->where('referencia_id', $productoId)
                    ->where('activa', 1)
                    ->where('fecha_inicio <=', $fechaActual)
                    ->where('fecha_fin >=', $fechaActual)
                    ->findAll();
    }

    /**
     * Obtiene ofertas para un combo específico.
     * @param int $comboId
     * @return array
     */
    public function getOfertasCombo(int $comboId): array
    {
        $fechaActual = date('Y-m-d');
        return $this->where('tipo', 'combo')
                    ->where('referencia_id', $comboId)
                    ->where('activa', 1)
                    ->where('fecha_inicio <=', $fechaActual)
                    ->where('fecha_fin >=', $fechaActual)
                    ->findAll();
    }

    /**
     * Calcula el precio con descuento.
     * @param float $precioOriginal
     * @param int $descuentoPorcentaje
     * @return float
     */
    public function calcularPrecioConDescuento(float $precioOriginal, int $descuentoPorcentaje): float
    {
        return $precioOriginal * (1 - $descuentoPorcentaje / 100);
    }

    /**
     * Obtiene ofertas con información del producto/combo.
     * @return array
     */
    public function getOfertasConDetalles(): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ofertas o');
        $builder->select('o.*, p.nombre as producto_nombre, p.precio as producto_precio, c.nombre as combo_nombre, c.precio as combo_precio');
        $builder->join('productos p', 'o.referencia_id = p.id AND o.tipo = "producto"', 'left');
        $builder->join('combos c', 'o.referencia_id = c.id AND o.tipo = "combo"', 'left');
        $builder->orderBy('o.fecha_inicio', 'desc');
        return $builder->get()->getResultArray();
    }

    /**
     * Verifica si una oferta está vigente.
     * @param int $ofertaId
     * @return bool
     */
    public function esVigente(int $ofertaId): bool
    {
        $fechaActual = date('Y-m-d');
        $oferta = $this->find($ofertaId);
        
        if (!$oferta) {
            return false;
        }
        
        return $oferta['activa'] == 1 && 
               $oferta['fecha_inicio'] <= $fechaActual && 
               $oferta['fecha_fin'] >= $fechaActual;
    }
} 