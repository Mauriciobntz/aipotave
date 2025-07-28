<?php
namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para la tabla 'calificaciones'.
 * Maneja las calificaciones y comentarios de los pedidos.
 */
class CalificacionModel extends Model
{
    protected $table = 'calificaciones';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'pedido_id', 'puntuacion', 'comentario', 'fecha'
    ];

    /**
     * Obtiene las calificaciones de un pedido específico.
     * @param int $pedidoId
     * @return array|null
     */
    public function getByPedidoId(int $pedidoId): ?array
    {
        return $this->where('pedido_id', $pedidoId)->first();
    }

    /**
     * Obtiene todas las calificaciones con información del pedido.
     * @return array
     */
    public function getAllCalificaciones(): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('calificaciones c');
        $builder->select('c.*, p.nombre as nombre_pedido, p.codigo_seguimiento');
        $builder->join('pedidos p', 'c.pedido_id = p.id');
        $builder->orderBy('c.fecha', 'desc');
        return $builder->get()->getResultArray();
    }

    /**
     * Calcula el promedio de calificaciones.
     * @return float
     */
    public function getPromedioCalificaciones(): float
    {
        $result = $this->select('AVG(puntuacion) as promedio')->first();
        return $result ? (float)$result['promedio'] : 0.0;
    }

    /**
     * Obtiene estadísticas de calificaciones.
     * @return array
     */
    public function getEstadisticasCalificaciones(): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('calificaciones');
        $builder->select('puntuacion, COUNT(*) as cantidad');
        $builder->groupBy('puntuacion');
        $builder->orderBy('puntuacion', 'desc');
        return $builder->get()->getResultArray();
    }

    /**
     * Verifica si un pedido ya tiene calificación.
     * @param int $pedidoId
     * @return bool
     */
    public function tieneCalificacion(int $pedidoId): bool
    {
        return $this->where('pedido_id', $pedidoId)->countAllResults() > 0;
    }
} 