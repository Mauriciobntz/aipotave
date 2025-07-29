<?php
namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para la tabla 'ubicaciones_repartidores'.
 * Maneja las ubicaciones GPS de los repartidores.
 */
class UbicacionRepartidorModel extends Model
{
    protected $table = 'ubicaciones_repartidores';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'repartidor_id', 'pedido_id', 'latitud', 'longitud', 'fecha'
    ];

    /**
     * Obtiene la última ubicación de un repartidor.
     * @param int $repartidorId
     * @return array|null
     */
    public function getUltimaUbicacion(int $repartidorId): ?array
    {
        return $this->where('repartidor_id', $repartidorId)
                    ->orderBy('fecha', 'desc')
                    ->first();
    }

    /**
     * Obtiene la ubicación de un repartidor para un pedido específico.
     * @param int $repartidorId
     * @param int $pedidoId
     * @return array|null
     */
    public function getUbicacionPorPedido(int $repartidorId, int $pedidoId): ?array
    {
        return $this->where('repartidor_id', $repartidorId)
                    ->where('pedido_id', $pedidoId)
                    ->orderBy('fecha', 'desc')
                    ->first();
    }

    /**
     * Registra una nueva ubicación.
     * @param int $repartidorId
     * @param int|null $pedidoId
     * @param float $latitud
     * @param float $longitud
     * @return int|false
     */
    public function registrarUbicacion(int $repartidorId, ?int $pedidoId, float $latitud, float $longitud)
    {
        return $this->insert([
            'repartidor_id' => $repartidorId,
            'pedido_id' => $pedidoId,
            'latitud' => $latitud,
            'longitud' => $longitud,
            'fecha' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Obtiene el historial de ubicaciones de un repartidor.
     * @param int $repartidorId
     * @param int $horas
     * @return array
     */
    public function getHistorialUbicaciones(int $repartidorId, int $horas = 24): array
    {
        $fechaInicio = date('Y-m-d H:i:s', strtotime("-{$horas} hours"));
        return $this->where('repartidor_id', $repartidorId)
                    ->where('fecha >=', $fechaInicio)
                    ->orderBy('fecha', 'asc')
                    ->findAll();
    }

    /**
     * Obtiene todas las ubicaciones activas de repartidores.
     * @return array
     */
    public function getUbicacionesActivas(): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ubicaciones_repartidores ur');
        $builder->select('ur.*, r.nombre as repartidor_nombre, p.codigo_seguimiento');
        $builder->join('repartidores r', 'ur.repartidor_id = r.id');
        $builder->join('pedidos p', 'ur.pedido_id = p.id');
        $builder->where('ur.fecha >=', date('Y-m-d H:i:s', strtotime('-1 hour')));
        $builder->orderBy('ur.fecha', 'desc');
        return $builder->get()->getResultArray();
    }

    /**
     * Calcula la distancia entre dos puntos GPS.
     * @param float $lat1
     * @param float $lon1
     * @param float $lat2
     * @param float $lon2
     * @return float Distancia en kilómetros
     */
    public function calcularDistancia(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371; // Radio de la Tierra en kilómetros
        
        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);
        
        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDelta / 2) * sin($lonDelta / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        return $earthRadius * $c;
    }

    /**
     * Obtiene repartidores cercanos a una ubicación.
     * @param float $latitud
     * @param float $longitud
     * @param float $radioKm
     * @return array
     */
    public function getRepartidoresCercanos(float $latitud, float $longitud, float $radioKm = 5): array
    {
        $ubicaciones = $this->getUbicacionesActivas();
        $repartidoresCercanos = [];
        
        foreach ($ubicaciones as $ubicacion) {
            $distancia = $this->calcularDistancia(
                $latitud, $longitud,
                $ubicacion['latitud'], $ubicacion['longitud']
            );
            
            if ($distancia <= $radioKm) {
                $ubicacion['distancia'] = $distancia;
                $repartidoresCercanos[] = $ubicacion;
            }
        }
        
        // Ordenar por distancia
        usort($repartidoresCercanos, function($a, $b) {
            return $a['distancia'] <=> $b['distancia'];
        });
        
        return $repartidoresCercanos;
    }
} 