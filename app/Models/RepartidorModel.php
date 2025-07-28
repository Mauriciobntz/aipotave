<?php
namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para la gestión de repartidores y su ubicación.
 */
class RepartidorModel extends Model
{
    protected $table = 'repartidores';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre', 'telefono', 'vehiculo', 'activo', 'email', 'password', 'disponible'
    ];

    /**
     * Obtiene todos los repartidores activos.
     * @return array
     */
    public function listarActivos(): array
    {
        return $this->where('activo', 1)->orderBy('nombre', 'asc')->findAll();
    }

    /**
     * Obtiene repartidores disponibles.
     * @return array
     */
    public function listarDisponibles(): array
    {
        return $this->where('activo', 1)
                    ->where('disponible', 1)
                    ->orderBy('nombre', 'asc')
                    ->findAll();
    }

    /**
     * Obtiene un repartidor por ID.
     * @param int $id
     * @return array|null
     */
    public function getById($id): ?array
    {
        return $this->where('id', $id)->first();
    }

    /**
     * Obtiene un repartidor por email.
     * @param string $email
     * @return array|null
     */
    public function getByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Actualiza la disponibilidad de un repartidor.
     * @param int $id
     * @param bool $disponible
     * @return bool
     */
    public function actualizarDisponibilidad(int $id, bool $disponible): bool
    {
        return $this->update($id, ['disponible' => $disponible ? 1 : 0]);
    }

    /**
     * Actualiza la ubicación de un repartidor para un pedido.
     * @param int $repartidor_id
     * @param int $pedido_id
     * @param float $latitud
     * @param float $longitud
     * @return void
     */
    public function actualizarUbicacion($repartidor_id, $pedido_id, $latitud, $longitud)
    {
        $ubicacionModel = new \App\Models\UbicacionRepartidorModel();
        $ubicacionModel->registrarUbicacion($repartidor_id, $pedido_id, $latitud, $longitud);
    }

    /**
     * Obtiene estadísticas de repartidores.
     * @return array
     */
    public function getEstadisticasRepartidores(): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('repartidores r');
        $builder->select('r.nombre, r.vehiculo, r.disponible, COUNT(p.id) as pedidos_asignados');
        $builder->join('pedidos p', 'r.id = p.repartidor_id', 'left');
        $builder->where('r.activo', 1);
        $builder->groupBy('r.id');
        $builder->orderBy('pedidos_asignados', 'desc');
        return $builder->get()->getResultArray();
    }
} 