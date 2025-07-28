<?php
namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para la tabla 'slides'.
 * Maneja los slides del carrusel principal.
 */
class SlideModel extends Model
{
    protected $table = 'slides';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'titulo', 'subtitulo', 'imagen', 'link_destino', 'activo', 'orden', 'fecha_creacion'
    ];

    /**
     * Obtiene todos los slides activos ordenados.
     * @return array
     */
    public function getSlidesActivos(): array
    {
        return $this->where('activo', 1)
                    ->orderBy('orden', 'asc')
                    ->orderBy('fecha_creacion', 'desc')
                    ->findAll();
    }

    /**
     * Obtiene slides para el carrusel principal.
     * @return array
     */
    public function getSlidesCarrusel(): array
    {
        return $this->where('activo', 1)
                    ->where('imagen IS NOT NULL')
                    ->orderBy('orden', 'asc')
                    ->findAll();
    }

    /**
     * Obtiene el siguiente orden disponible.
     * @return int
     */
    public function getSiguienteOrden(): int
    {
        $result = $this->selectMax('orden')->first();
        return $result ? (int)$result['orden'] + 1 : 1;
    }

    /**
     * Activa un slide.
     * @param int $id
     * @return bool
     */
    public function activar(int $id): bool
    {
        return $this->update($id, ['activo' => 1]);
    }

    /**
     * Desactiva un slide.
     * @param int $id
     * @return bool
     */
    public function desactivar(int $id): bool
    {
        return $this->update($id, ['activo' => 0]);
    }

    /**
     * Reordena los slides.
     * @param array $ordenes Array con id => orden
     * @return bool
     */
    public function reordenar(array $ordenes): bool
    {
        $db = \Config\Database::connect();
        $db->transStart();
        
        foreach ($ordenes as $id => $orden) {
            $this->update($id, ['orden' => $orden]);
        }
        
        return $db->transComplete();
    }
} 