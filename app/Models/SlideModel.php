<?php

namespace App\Models;

use CodeIgniter\Model;

class SlideModel extends Model
{
    protected $table = 'slides';
    protected $primaryKey = 'id';
    protected $allowedFields = ['titulo', 'subtitulo', 'imagen', 'link_destino', 'activo', 'orden', 'fecha_creacion'];
    protected $useTimestamps = false;
    protected $returnType = 'array';

    /**
     * Obtiene todos los slides activos ordenados por orden
     */
    public function getSlidesActivos()
    {
        return $this->where('activo', 1)
                   ->orderBy('orden', 'ASC')
                   ->findAll();
    }

    /**
     * Obtiene slides activos con límite
     */
    public function getSlidesActivosLimit($limit = 5)
    {
        return $this->where('activo', 1)
                   ->orderBy('orden', 'ASC')
                   ->findAll($limit);
    }

    /**
     * Obtiene un slide por ID
     */
    public function getSlideById($id)
    {
        return $this->find($id);
    }

    /**
     * Crea un nuevo slide
     */
    public function crearSlide($data)
    {
        return $this->insert($data);
    }

    /**
     * Actualiza un slide
     */
    public function actualizarSlide($id, $data)
    {
        return $this->update($id, $data);
    }

    /**
     * Elimina un slide (cambia estado a inactivo)
     */
    public function eliminarSlide($id)
    {
        return $this->update($id, ['activo' => 0]);
    }

    /**
     * Obtiene el siguiente orden disponible
     */
    public function getSiguienteOrden()
    {
        $result = $this->selectMax('orden')->first();
        return $result ? (int)$result['orden'] + 1 : 1;
    }
} 