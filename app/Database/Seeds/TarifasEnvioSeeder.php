<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TarifasEnvioSeeder extends Seeder
{
    public function run()
    {
        // Limpiar tabla existente
        $this->db->table('tarifas_envio')->truncate();
        
        // Insertar tarifas corregidas
        $tarifas = [
            [
                'nombre' => 'Envío Local (0-1 km)',
                'distancia_minima' => 0.00,
                'distancia_maxima' => 1.00,
                'costo' => 0.00,
                'descripcion' => 'Envío gratuito para distancias hasta 1 km',
                'activo' => 1,
                'orden' => 1,
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'fecha_actualizacion' => date('Y-m-d H:i:s')
            ],
            [
                'nombre' => 'Envío Local (1-2 km)',
                'distancia_minima' => 1.00,
                'distancia_maxima' => 2.00,
                'costo' => 500.00,
                'descripcion' => 'Envío local para distancias entre 1 y 2 km',
                'activo' => 1,
                'orden' => 2,
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'fecha_actualizacion' => date('Y-m-d H:i:s')
            ],
            [
                'nombre' => 'Envío Local (2-3 km)',
                'distancia_minima' => 2.00,
                'distancia_maxima' => 3.00,
                'costo' => 1000.00,
                'descripcion' => 'Envío local para distancias entre 2 y 3 km',
                'activo' => 1,
                'orden' => 3,
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'fecha_actualizacion' => date('Y-m-d H:i:s')
            ],
            [
                'nombre' => 'Envío Local (3-5 km)',
                'distancia_minima' => 3.00,
                'distancia_maxima' => 5.00,
                'costo' => 1500.00,
                'descripcion' => 'Envío local para distancias entre 3 y 5 km',
                'activo' => 1,
                'orden' => 4,
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'fecha_actualizacion' => date('Y-m-d H:i:s')
            ]
        ];
        
        $this->db->table('tarifas_envio')->insertBatch($tarifas);
        
        echo "Tarifas de envío corregidas exitosamente.\n";
    }
}
