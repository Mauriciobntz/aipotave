<?php
namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para la tabla 'pedidos'.
 * Métodos para gestión interna de pedidos.
 */
class PedidoModel extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre', 'correo_electronico', 'celular', 'repartidor_id', 'fecha', 'estado', 'estado_pago', 'total', 'metodo_pago', 'observaciones', 'direccion_entrega', 'entre', 'indicacion', 'codigo_seguimiento', 'latitud', 'longitud'
    ];

    /**
     * Obtiene todos los pedidos ordenados por fecha descendente.
     * @return array
     */
    public function getAllPedidos(): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pedidos p');
        $builder->select('p.*');
        $builder->orderBy('p.fecha', 'desc');
        return $builder->get()->getResultArray();
    }

    /**
     * Obtiene pedidos filtrados por estado.
     * @param string $estado
     * @return array
     */
    public function getByEstado(string $estado): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pedidos p');
        $builder->select('p.*');
        $builder->where('p.estado', $estado);
        $builder->orderBy('p.fecha', 'desc');
        return $builder->get()->getResultArray();
    }

    /**
     * Obtiene un pedido por ID.
     * @param int $id
     * @return array|null
     */
    public function getById(int $id): ?array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pedidos p');
        $builder->select('p.*');
        $builder->where('p.id', $id);
        $result = $builder->get()->getRowArray();
        return $result ?: null;
    }

    /**
     * Actualiza el estado de un pedido y registra el cambio en el historial.
     * @param int $id
     * @param string $nuevoEstado
     * @return bool
     */
    public function actualizarEstado(int $id, string $nuevoEstado): bool
    {
        $pedido = $this->find($id);
        if (!$pedido) {
            return false;
        }

        $estadoAnterior = $pedido['estado'];
        $resultado = $this->update($id, ['estado' => $nuevoEstado]);

        if ($resultado) {
            // Registrar el cambio en el historial
            $historialModel = new \App\Models\HistorialEstadosModel();
            $historialModel->registrarCambio($id, $estadoAnterior, $nuevoEstado);
        }

        return $resultado;
    }

    /**
     * Asigna un repartidor a un pedido.
     * @param int $pedido_id
     * @param int $repartidor_id
     * @return bool
     */
    public function asignarRepartidor(int $pedido_id, int $repartidor_id): bool
    {
        return $this->update($pedido_id, ['repartidor_id' => $repartidor_id]);
    }

    /**
     * Genera un código de seguimiento único.
     * @return string
     */
    public function generarCodigoSeguimiento(): string
    {
        do {
            $codigo = strtoupper(substr(md5(uniqid()), 0, 8));
        } while ($this->where('codigo_seguimiento', $codigo)->first());
        
        return $codigo;
    }

    /**
     * Busca un pedido por código de seguimiento.
     * @param string $codigo
     * @return array|null
     */
    public function getByCodigoSeguimiento(string $codigo): ?array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pedidos p');
        $builder->select('p.*');
        $builder->where('p.codigo_seguimiento', $codigo);
        $result = $builder->get()->getRowArray();
        return $result ?: null;
    }

    /**
     * Obtiene estadísticas de pedidos por período.
     * @param string $fecha_inicio
     * @param string $fecha_fin
     * @return array
     */
    public function getEstadisticasPedidos(string $fecha_inicio, string $fecha_fin): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pedidos');
        $builder->select('estado, COUNT(*) as cantidad, SUM(total) as total_ventas');
        $builder->where('fecha >=', $fecha_inicio);
        $builder->where('fecha <=', $fecha_fin);
        $builder->groupBy('estado');
        $builder->orderBy('cantidad', 'desc');
        return $builder->get()->getResultArray();
    }

    /**
     * Obtiene pedidos con información completa incluyendo repartidor.
     * @param string $estado
     * @return array
     */
    public function getPedidosConRepartidor(string $estado = null): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pedidos p');
        $builder->select('p.*, r.nombre as nombre_repartidor');
        $builder->join('repartidores r', 'p.repartidor_id = r.id', 'left');
        
        if ($estado) {
            $builder->where('p.estado', $estado);
        }
        
        $builder->orderBy('p.fecha', 'desc');
        return $builder->get()->getResultArray();
    }
} 