<?php
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre', 'email', 'telefono', 'direccion', 'fecha_registro', 'activo'
    ];
    protected $returnType = 'array';

    /**
     * Buscar usuario por email
     */
    public function getByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Buscar usuario por ID
     */
    public function getById(int $id): ?array
    {
        return $this->find($id);
    }

    /**
     * Listar todos los usuarios activos
     */
    public function listarActivos(): array
    {
        return $this->where('activo', 1)->findAll();
    }

    /**
     * Crear un nuevo usuario
     */
    public function crearUsuario(array $data): int
    {
        $data['fecha_registro'] = date('Y-m-d H:i:s');
        $data['activo'] = 1;
        return $this->insert($data);
    }
} 