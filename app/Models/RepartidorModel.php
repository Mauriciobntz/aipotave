<?php

namespace App\Models;

use CodeIgniter\Model;

class RepartidorModel extends Model
{
    protected $table = 'repartidores';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'telefono', 'vehiculo', 'activo', 'email', 'password', 'disponible'];
    protected $useTimestamps = false;
    
    /**
     * Obtiene repartidores activos con su carga de trabajo
     */
    public function getRepartidoresDisponibles()
    {
        $db = \CodeIgniter\Database\Config::connect();
        
        $query = $db->query("
            SELECT 
                r.id,
                r.nombre,
                r.email,
                r.activo,
                COUNT(p.id) as pedidos_en_camino
            FROM repartidores r
            LEFT JOIN pedidos p ON r.id = p.repartidor_id AND p.estado = 'en_camino'
            WHERE r.activo = 1
            GROUP BY r.id, r.nombre, r.email, r.activo
            ORDER BY pedidos_en_camino ASC, r.nombre ASC
            LIMIT 10
        ");
        
        return $query->getResultArray();
    }
    
    /**
     * Obtiene un repartidor por ID
     */
    public function getRepartidorById($id)
    {
        return $this->where('id', $id)
                    ->where('activo', 1)
                    ->first();
    }

    /**
     * Retorna todos los repartidores activos
     */
    public function listarActivos()
    {
        return $this->where('activo', 1)->orderBy('nombre', 'asc')->findAll();
    }
} 