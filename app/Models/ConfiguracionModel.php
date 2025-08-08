<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfiguracionModel extends Model
{
    protected $table = 'configuracion';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'clave', 
        'valor', 
        'descripcion', 
        'tipo', 
        'seccion', 
        'activo'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'fecha_creacion';
    protected $updatedField = 'fecha_actualizacion';

    protected $validationRules = [
        'clave' => 'required|max_length[100]|is_unique[configuracion.clave,id,{id}]',
        'valor' => 'permit_empty',
        'tipo' => 'required|in_list[texto,numero,email,url,telefono,direccion,horario]',
        'seccion' => 'required|in_list[general,navbar,footer,contacto,redes_sociales]',
        'activo' => 'required|in_list[0,1]'
    ];

    protected $validationMessages = [
        'clave' => [
            'required' => 'La clave es obligatoria',
            'max_length' => 'La clave no puede tener más de 100 caracteres',
            'is_unique' => 'Esta clave ya existe'
        ],
        'tipo' => [
            'required' => 'El tipo es obligatorio',
            'in_list' => 'El tipo debe ser uno de los valores permitidos'
        ],
        'seccion' => [
            'required' => 'La sección es obligatoria',
            'in_list' => 'La sección debe ser una de las permitidas'
        ],
        'activo' => [
            'required' => 'El estado activo es obligatorio',
            'in_list' => 'El estado activo debe ser 0 o 1'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Obtiene el valor de una configuración por clave
     */
    public function getValor($clave, $default = null)
    {
        $config = $this->where('clave', $clave)
                      ->where('activo', 1)
                      ->first();
        
        return $config ? $config['valor'] : $default;
    }

    /**
     * Obtiene múltiples configuraciones por sección
     */
    public function getPorSeccion($seccion)
    {
        return $this->where('seccion', $seccion)
                   ->where('activo', 1)
                   ->findAll();
    }

    /**
     * Obtiene todas las configuraciones activas como array asociativo
     */
    public function getAllAsArray()
    {
        $configs = $this->where('activo', 1)->findAll();
        $result = [];
        
        foreach ($configs as $config) {
            $result[$config['clave']] = $config['valor'];
        }
        
        return $result;
    }

    /**
     * Actualiza el valor de una configuración
     */
    public function actualizarValor($clave, $valor)
    {
        return $this->where('clave', $clave)
                   ->set(['valor' => $valor])
                   ->update();
    }

    /**
     * Obtiene configuraciones por tipo
     */
    public function getPorTipo($tipo)
    {
        return $this->where('tipo', $tipo)
                   ->where('activo', 1)
                   ->findAll();
    }

    /**
     * Obtiene configuraciones de contacto
     */
    public function getContacto()
    {
        return $this->getPorSeccion('contacto');
    }

    /**
     * Obtiene configuraciones de redes sociales
     */
    public function getRedesSociales()
    {
        return $this->getPorSeccion('redes_sociales');
    }

    /**
     * Obtiene configuraciones del footer
     */
    public function getFooter()
    {
        return $this->getPorSeccion('footer');
    }

    /**
     * Obtiene configuraciones del navbar
     */
    public function getNavbar()
    {
        return $this->getPorSeccion('navbar');
    }

    /**
     * Obtiene configuraciones generales
     */
    public function getGeneral()
    {
        return $this->getPorSeccion('general');
    }

    /**
     * Verifica si existe una configuración
     */
    public function existe($clave)
    {
        return $this->where('clave', $clave)
                   ->where('activo', 1)
                   ->countAllResults() > 0;
    }

    /**
     * Obtiene configuraciones con paginación
     */
    public function getConPaginacion($page = 1, $perPage = 20, $filtros = [])
    {
        $builder = $this->builder();
        
        // Aplicar filtros
        if (!empty($filtros['seccion'])) {
            $builder->where('seccion', $filtros['seccion']);
        }
        
        if (!empty($filtros['tipo'])) {
            $builder->where('tipo', $filtros['tipo']);
        }
        
        if (isset($filtros['activo'])) {
            $builder->where('activo', $filtros['activo']);
        }
        
        if (!empty($filtros['buscar'])) {
            $builder->groupStart()
                   ->like('clave', $filtros['buscar'])
                   ->orLike('valor', $filtros['buscar'])
                   ->orLike('descripcion', $filtros['buscar'])
                   ->groupEnd();
        }
        
        $total = $builder->countAllResults(false);
        
        $offset = ($page - 1) * $perPage;
        $configs = $builder->limit($perPage, $offset)
                          ->orderBy('seccion', 'ASC')
                          ->orderBy('clave', 'ASC')
                          ->get()
                          ->getResultArray();
        
        return [
            'data' => $configs,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => ceil($total / $perPage)
        ];
    }

    /**
     * Obtiene la latitud del punto de partida
     */
    public function getPuntoPartidaLatitud()
    {
        return $this->getValor('punto_partida_latitud', '-25.291388888889');
    }

    /**
     * Obtiene la longitud del punto de partida
     */
    public function getPuntoPartidaLongitud()
    {
        return $this->getValor('punto_partida_longitud', '-57.718333333333');
    }

    /**
     * Obtiene la dirección del punto de partida
     */
    public function getPuntoPartidaDireccion()
    {
        return $this->getValor('punto_partida_direccion', 'Clorinda, Formosa, Argentina');
    }

    /**
     * Obtiene el nombre del punto de partida
     */
    public function getPuntoPartidaNombre()
    {
        return $this->getValor('punto_partida_nombre', 'Restaurante Max');
    }

    /**
     * Obtiene todos los datos del punto de partida como array
     */
    public function getPuntoPartidaCompleto()
    {
        return [
            'latitud' => $this->getPuntoPartidaLatitud(),
            'longitud' => $this->getPuntoPartidaLongitud(),
            'direccion' => $this->getPuntoPartidaDireccion(),
            'nombre' => $this->getPuntoPartidaNombre()
        ];
    }

    /**
     * Obtiene la configuración del mapa de seguimiento
     */
    public function getMapaSeguimientoActivo()
    {
        return $this->getValor('mapa_seguimiento_activo', '1') === '1';
    }

    /**
     * Obtiene la configuración del mapa de seguimiento con detalles
     */
    public function getConfiguracionMapaSeguimiento()
    {
        return [
            'activo' => $this->getMapaSeguimientoActivo(),
            'tiempo_actualizacion' => $this->getValor('mapa_seguimiento_tiempo_actualizacion', '30'),
            'mostrar_ruta' => $this->getValor('mapa_seguimiento_mostrar_ruta', '1') === '1',
            'zoom_default' => $this->getValor('mapa_seguimiento_zoom_default', '15')
        ];
    }

    /**
     * Actualiza la configuración del mapa de seguimiento
     */
    public function actualizarConfiguracionMapaSeguimiento($configuracion)
    {
        $configuraciones = [
            'mapa_seguimiento_activo' => $configuracion['activo'] ?? '1',
            'mapa_seguimiento_tiempo_actualizacion' => $configuracion['tiempo_actualizacion'] ?? '30',
            'mapa_seguimiento_mostrar_ruta' => $configuracion['mostrar_ruta'] ?? '1',
            'mapa_seguimiento_zoom_default' => $configuracion['zoom_default'] ?? '15'
        ];

        foreach ($configuraciones as $clave => $valor) {
            $this->actualizarValor($clave, $valor);
        }

        return true;
    }
} 