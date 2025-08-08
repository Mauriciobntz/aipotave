<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPuntoPartidaConfiguracion extends Migration
{
    public function up()
    {
        $this->db->table('configuracion')->insertBatch([
            [
                'clave' => 'punto_partida_latitud',
                'valor' => '-25.291388888889',
                'descripcion' => 'Latitud del punto de partida del restaurante',
                'tipo' => 'numero',
                'seccion' => 'general',
                'activo' => 1,
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'fecha_actualizacion' => date('Y-m-d H:i:s')
            ],
            [
                'clave' => 'punto_partida_longitud',
                'valor' => '-57.718333333333',
                'descripcion' => 'Longitud del punto de partida del restaurante',
                'tipo' => 'numero',
                'seccion' => 'general',
                'activo' => 1,
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'fecha_actualizacion' => date('Y-m-d H:i:s')
            ],
            [
                'clave' => 'punto_partida_direccion',
                'valor' => 'Clorinda, Formosa, Argentina',
                'descripcion' => 'Dirección del punto de partida del restaurante',
                'tipo' => 'direccion',
                'seccion' => 'general',
                'activo' => 1,
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'fecha_actualizacion' => date('Y-m-d H:i:s')
            ],
            [
                'clave' => 'punto_partida_nombre',
                'valor' => 'Restaurante Max',
                'descripcion' => 'Nombre del punto de partida',
                'tipo' => 'texto',
                'seccion' => 'general',
                'activo' => 1,
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'fecha_actualizacion' => date('Y-m-d H:i:s')
            ]
        ]);
    }

    public function down()
    {
        $this->db->table('configuracion')->whereIn('clave', [
            'punto_partida_latitud',
            'punto_partida_longitud',
            'punto_partida_direccion',
            'punto_partida_nombre'
        ])->delete();
    }
}
