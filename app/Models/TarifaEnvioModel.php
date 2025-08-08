<?php

namespace App\Models;

use CodeIgniter\Model;

class TarifaEnvioModel extends Model
{
    protected $table = 'tarifas_envio';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'nombre',
        'distancia_minima',
        'distancia_maxima',
        'costo',
        'descripcion',
        'activo',
        'orden'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'fecha_creacion';
    protected $updatedField = 'fecha_actualizacion';

    protected $validationRules = [
        'nombre' => 'required|max_length[100]',
        'distancia_minima' => 'required|numeric|greater_than_equal_to[0]',
        'distancia_maxima' => 'required|numeric|greater_than[0]',
        'costo' => 'required|numeric|greater_than_equal_to[0]',
        'descripcion' => 'permit_empty|max_length[255]',
        'activo' => 'required|in_list[0,1]',
        'orden' => 'required|integer|greater_than_equal_to[0]'
    ];

    protected $validationMessages = [
        'nombre' => [
            'required' => 'El nombre es obligatorio',
            'max_length' => 'El nombre no puede tener más de 100 caracteres'
        ],
        'distancia_minima' => [
            'required' => 'La distancia mínima es obligatoria',
            'numeric' => 'La distancia mínima debe ser un número',
            'greater_than_equal_to' => 'La distancia mínima debe ser mayor o igual a 0'
        ],
        'distancia_maxima' => [
            'required' => 'La distancia máxima es obligatoria',
            'numeric' => 'La distancia máxima debe ser un número',
            'greater_than' => 'La distancia máxima debe ser mayor a 0'
        ],
        'costo' => [
            'required' => 'El costo es obligatorio',
            'numeric' => 'El costo debe ser un número',
            'greater_than_equal_to' => 'El costo debe ser mayor o igual a 0'
        ],
        'descripcion' => [
            'max_length' => 'La descripción no puede tener más de 255 caracteres'
        ],
        'activo' => [
            'required' => 'El estado activo es obligatorio',
            'in_list' => 'El estado activo debe ser 0 o 1'
        ],
        'orden' => [
            'required' => 'El orden es obligatorio',
            'integer' => 'El orden debe ser un número entero',
            'greater_than_equal_to' => 'El orden debe ser mayor o igual a 0'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Obtiene todas las tarifas activas ordenadas por orden
     */
    public function getTarifasActivas()
    {
        return $this->where('activo', 1)
                   ->orderBy('orden', 'ASC')
                   ->findAll();
    }

    /**
     * Calcula el costo de envío basado en la distancia
     */
    public function calcularCostoEnvio($distanciaKm)
    {
        $tarifas = $this->getTarifasActivas();
        
        // Log para depuración
        log_message('info', "=== CALCULANDO COSTO PARA {$distanciaKm} km ===");
        log_message('info', "Tarifas activas encontradas: " . count($tarifas));
        
        foreach ($tarifas as $index => $tarifa) {
            log_message('info', "Evaluando tarifa {$index}: {$tarifa['nombre']} - Rango: {$tarifa['distancia_minima']}-{$tarifa['distancia_maxima']} km - Costo: {$tarifa['costo']}");
            
            if ($distanciaKm >= $tarifa['distancia_minima'] && $distanciaKm <= $tarifa['distancia_maxima']) {
                log_message('info', "✓ TARIFA ENCONTRADA: {$tarifa['nombre']} - Costo: {$tarifa['costo']}");
                return [
                    'costo' => $tarifa['costo'],
                    'tarifa' => $tarifa
                ];
            } else {
                log_message('info', "✗ No coincide: {$distanciaKm} no está entre {$tarifa['distancia_minima']} y {$tarifa['distancia_maxima']}");
            }
        }
        
        // Si no encuentra tarifa, devolver la más cara
        $tarifaMasCara = $this->where('activo', 1)
                              ->orderBy('costo', 'DESC')
                              ->get()
                              ->getRowArray();
        
        log_message('info', "No se encontró tarifa específica, usando la más cara: " . ($tarifaMasCara ? $tarifaMasCara['nombre'] : 'Ninguna'));
        
        return [
            'costo' => $tarifaMasCara ? $tarifaMasCara['costo'] : 0,
            'tarifa' => $tarifaMasCara
        ];
    }

    /**
     * Obtiene tarifas con paginación
     */
    public function getConPaginacion($page = 1, $perPage = 20, $filtros = [])
    {
        $builder = $this->builder();
        
        // Aplicar filtros
        if (!empty($filtros['nombre'])) {
            $builder->like('nombre', $filtros['nombre']);
        }
        
        if (isset($filtros['activo']) && $filtros['activo'] !== '') {
            $builder->where('activo', $filtros['activo']);
        }
        
        // Contar total de registros
        $total = $builder->countAllResults(false);
        
        // Obtener registros paginados
        $offset = ($page - 1) * $perPage;
        $tarifas = $builder->orderBy('orden', 'ASC')
                           ->limit($perPage, $offset)
                           ->get()
                           ->getResultArray();
        
        return [
            'tarifas' => $tarifas,
            'total' => $total,
            'paginas' => ceil($total / $perPage),
            'pagina_actual' => $page
        ];
    }

    /**
     * Verifica si hay solapamiento de rangos de distancia
     */
    public function verificarSolapamiento($distanciaMinima, $distanciaMaxima, $excluirId = null)
    {
        $builder = $this->builder();
        
        if ($excluirId) {
            $builder->where('id !=', $excluirId);
        }
        
        $builder->where('activo', 1);
        
        // Verificar solapamiento usando condiciones más simples
        $builder->groupStart()
                ->where('distancia_minima <=', $distanciaMinima)
                ->where('distancia_maxima >=', $distanciaMinima)
                ->groupEnd();
        
        $builder->orGroupStart()
                ->where('distancia_minima <=', $distanciaMaxima)
                ->where('distancia_maxima >=', $distanciaMaxima)
                ->groupEnd();
        
        $builder->orGroupStart()
                ->where('distancia_minima >=', $distanciaMinima)
                ->where('distancia_maxima <=', $distanciaMaxima)
                ->groupEnd();
        
        $solapamiento = $builder->get()->getRowArray();
        
        return $solapamiento !== null;
    }

    /**
     * Obtiene el siguiente orden disponible
     */
    public function getSiguienteOrden()
    {
        $ultimoOrden = $this->builder()->selectMax('orden')->get()->getRowArray();
        return ($ultimoOrden['orden'] ?? 0) + 1;
    }
}
