<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMapaSeguimientoConfiguracion extends Migration
{
    public function up()
    {
        // Agregar configuraciones del mapa de seguimiento
        $this->db->table('configuracion')->insertBatch([
            [
                'clave' => 'mapa_seguimiento_activo',
                'valor' => '1',
                'descripcion' => 'Activa o desactiva el mapa de seguimiento en tiempo real',
                'tipo' => 'texto',
                'seccion' => 'general',
                'activo' => 1,
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'fecha_actualizacion' => date('Y-m-d H:i:s')
            ],
            [
                'clave' => 'mapa_seguimiento_tiempo_actualizacion',
                'valor' => '30',
                'descripcion' => 'Tiempo de actualización del mapa de seguimiento en segundos',
                'tipo' => 'numero',
                'seccion' => 'general',
                'activo' => 1,
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'fecha_actualizacion' => date('Y-m-d H:i:s')
            ],
            [
                'clave' => 'mapa_seguimiento_mostrar_ruta',
                'valor' => '1',
                'descripcion' => 'Muestra la ruta del repartidor en el mapa de seguimiento',
                'tipo' => 'texto',
                'seccion' => 'general',
                'activo' => 1,
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'fecha_actualizacion' => date('Y-m-d H:i:s')
            ],
            [
                'clave' => 'mapa_seguimiento_zoom_default',
                'valor' => '15',
                'descripcion' => 'Nivel de zoom por defecto del mapa de seguimiento',
                'tipo' => 'numero',
                'seccion' => 'general',
                'activo' => 1,
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'fecha_actualizacion' => date('Y-m-d H:i:s')
            ]
        ]);
    }

    public function down()
    {
        // Eliminar configuraciones del mapa de seguimiento
        $this->db->table('configuracion')->whereIn('clave', [
            'mapa_seguimiento_activo',
            'mapa_seguimiento_tiempo_actualizacion',
            'mapa_seguimiento_mostrar_ruta',
            'mapa_seguimiento_zoom_default'
        ])->delete();
    }
}
