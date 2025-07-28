<?php
namespace App\Models;

use CodeIgniter\Model;

class EmpleadoModel extends Model
{
    protected $table = 'empleados';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre', 'email', 'password', 'rol', 'activo'
    ];
    protected $returnType = 'array';

    /**
     * Buscar empleado por email
     */
    public function getByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Buscar empleado por ID
     */
    public function getById(int $id): ?array
    {
        return $this->find($id);
    }

    /**
     * Listar todos los empleados activos
     */
    public function listarActivos(): array
    {
        return $this->where('activo', 1)->findAll();
    }
} 