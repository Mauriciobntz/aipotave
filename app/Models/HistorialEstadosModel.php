<?php
namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para la tabla 'historial_estados'.
 * Maneja el historial de cambios de estado de los pedidos.
 */
class HistorialEstadosModel extends Model
{
    protected $table = 'historial_estados';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'pedido_id', 'estado_anterior', 'estado_nuevo', 'fecha_cambio'
    ];

    /**
     * Registra un cambio de estado en el historial.
     * @param int $pedidoId
     * @param string $estadoAnterior
     * @param string $estadoNuevo
     * @return int|false
     */
    public function registrarCambio(int $pedidoId, string $estadoAnterior, string $estadoNuevo)
    {
        return $this->insert([
            'pedido_id' => $pedidoId,
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo' => $estadoNuevo,
            'fecha_cambio' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Obtiene el historial completo de un pedido.
     * @param int $pedidoId
     * @return array
     */
    public function getHistorialPedido(int $pedidoId): array
    {
        return $this->where('pedido_id', $pedidoId)
                    ->orderBy('fecha_cambio', 'asc')
                    ->findAll();
    }

    /**
     * Obtiene el historial de un pedido por su ID (alias de getHistorialPedido).
     * @param int $pedidoId
     * @return array
     */
    public function getByPedidoId(int $pedidoId): array
    {
        return $this->getHistorialPedido($pedidoId);
    }

    /**
     * Obtiene el último cambio de estado de un pedido.
     * @param int $pedidoId
     * @return array|null
     */
    public function getUltimoCambio(int $pedidoId): ?array
    {
        return $this->where('pedido_id', $pedidoId)
                    ->orderBy('fecha_cambio', 'desc')
                    ->first();
    }

    /**
     * Obtiene todos los cambios de estado con información del pedido.
     * @return array
     */
    public function getAllHistorial(): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('historial_estados h');
        $builder->select('h.*, p.nombre as nombre_pedido, p.codigo_seguimiento');
        $builder->join('pedidos p', 'h.pedido_id = p.id');
        $builder->orderBy('h.fecha_cambio', 'desc');
        return $builder->get()->getResultArray();
    }

    /**
     * Obtiene cambios de estado por período.
     * @param string $fechaInicio
     * @param string $fechaFin
     * @return array
     */
    public function getCambiosPorPeriodo(string $fechaInicio, string $fechaFin): array
    {
        return $this->where('fecha_cambio >=', $fechaInicio)
                    ->where('fecha_cambio <=', $fechaFin)
                    ->orderBy('fecha_cambio', 'desc')
                    ->findAll();
    }

    /**
     * Obtiene estadísticas de cambios de estado.
     * @return array
     */
    public function getEstadisticasCambios(): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('historial_estados');
        $builder->select('estado_nuevo, COUNT(*) as cantidad');
        $builder->groupBy('estado_nuevo');
        $builder->orderBy('cantidad', 'desc');
        return $builder->get()->getResultArray();
    }

    /**
     * Obtiene el tiempo promedio entre cambios de estado.
     * @param string $estadoAnterior
     * @param string $estadoNuevo
     * @return float Tiempo promedio en minutos
     */
    public function getTiempoPromedioCambio(string $estadoAnterior, string $estadoNuevo): float
    {
        $db = \Config\Database::connect();
        $builder = $db->table('historial_estados h1');
        $builder->select('AVG(TIMESTAMPDIFF(MINUTE, h1.fecha_cambio, h2.fecha_cambio)) as tiempo_promedio');
        $builder->join('historial_estados h2', 'h1.pedido_id = h2.pedido_id AND h1.fecha_cambio < h2.fecha_cambio');
        $builder->where('h1.estado_nuevo', $estadoAnterior);
        $builder->where('h2.estado_nuevo', $estadoNuevo);
        
        $result = $builder->get()->getRowArray();
        return $result ? (float)$result['tiempo_promedio'] : 0.0;
    }

    /**
     * Obtiene el tiempo total de un pedido en cada estado.
     * @param int $pedidoId
     * @return array
     */
    public function getTiemposPorEstado(int $pedidoId): array
    {
        $historial = $this->getHistorialPedido($pedidoId);
        $tiempos = [];
        
        for ($i = 0; $i < count($historial) - 1; $i++) {
            $estado = $historial[$i]['estado_nuevo'];
            $inicio = strtotime($historial[$i]['fecha_cambio']);
            $fin = strtotime($historial[$i + 1]['fecha_cambio']);
            $duracion = ($fin - $inicio) / 60; // en minutos
            
            if (!isset($tiempos[$estado])) {
                $tiempos[$estado] = 0;
            }
            $tiempos[$estado] += $duracion;
        }
        
        // Agregar el estado actual (desde el último cambio hasta ahora)
        if (!empty($historial)) {
            $ultimoEstado = end($historial)['estado_nuevo'];
            $ultimoCambio = strtotime(end($historial)['fecha_cambio']);
            $ahora = time();
            $duracionActual = ($ahora - $ultimoCambio) / 60;
            
            if (!isset($tiempos[$ultimoEstado])) {
                $tiempos[$ultimoEstado] = 0;
            }
            $tiempos[$ultimoEstado] += $duracionActual;
        }
        
        return $tiempos;
    }
} 