<?php
namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para la tabla 'notificaciones'.
 * Maneja las notificaciones del sistema (email, WhatsApp).
 */
class NotificacionModel extends Model
{
    protected $table = 'notificaciones';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'pedido_id', 'tipo', 'contenido', 'fecha_envio', 'estado'
    ];

    /**
     * Obtiene las notificaciones de un pedido específico.
     * @param int $pedidoId
     * @return array
     */
    public function getByPedidoId(int $pedidoId): array
    {
        return $this->where('pedido_id', $pedidoId)->orderBy('fecha_envio', 'desc')->findAll();
    }

    /**
     * Obtiene todas las notificaciones con información del pedido.
     * @return array
     */
    public function getAllNotificaciones(): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('notificaciones n');
        $builder->select('n.*, p.nombre as nombre_pedido, p.codigo_seguimiento');
        $builder->join('pedidos p', 'n.pedido_id = p.id');
        $builder->orderBy('n.fecha_envio', 'desc');
        return $builder->get()->getResultArray();
    }

    /**
     * Obtiene notificaciones pendientes.
     * @return array
     */
    public function getPendientes(): array
    {
        return $this->where('estado', 'pendiente')->findAll();
    }

    /**
     * Marca una notificación como enviada.
     * @param int $id
     * @return bool
     */
    public function marcarEnviada(int $id): bool
    {
        return $this->update($id, ['estado' => 'enviado']);
    }

    /**
     * Marca una notificación como fallida.
     * @param int $id
     * @return bool
     */
    public function marcarFallida(int $id): bool
    {
        return $this->update($id, ['estado' => 'fallido']);
    }

    /**
     * Crea una notificación para un pedido.
     * @param int $pedidoId
     * @param string $tipo
     * @param string $contenido
     * @return int|false
     */
    public function crearNotificacion(int $pedidoId, string $tipo, string $contenido)
    {
        return $this->insert([
            'pedido_id' => $pedidoId,
            'tipo' => $tipo,
            'contenido' => $contenido,
            'fecha_envio' => date('Y-m-d H:i:s'),
            'estado' => 'pendiente'
        ]);
    }

    /**
     * Registra una notificación (alias de crearNotificacion).
     * @param int $pedidoId
     * @param string $tipo
     * @param string $contenido
     * @param int|null $repartidor_id
     * @return int|false
     */
    public function registrarNotificacion(int $pedidoId, string $tipo, string $contenido, $repartidor_id = null)
    {
        $datos = [
            'pedido_id' => $pedidoId,
            'tipo' => $tipo,
            'contenido' => $contenido,
            'fecha_envio' => date('Y-m-d H:i:s'),
            'estado' => 'pendiente'
        ];
        
        if ($repartidor_id) {
            $datos['repartidor_id'] = $repartidor_id;
        }
        
        return $this->insert($datos);
    }

    /**
     * Obtiene estadísticas de notificaciones.
     * @return array
     */
    public function getEstadisticas(): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('notificaciones');
        $builder->select('estado, COUNT(*) as cantidad');
        $builder->groupBy('estado');
        return $builder->get()->getResultArray();
    }
} 