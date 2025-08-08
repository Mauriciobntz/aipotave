<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTarifasEnvio extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nombre' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'distancia_minima' => [
                'type' => 'DECIMAL',
                'constraint' => '8,2',
                'null' => false,
                'default' => 0,
            ],
            'distancia_maxima' => [
                'type' => 'DECIMAL',
                'constraint' => '8,2',
                'null' => false,
                'default' => 0,
            ],
            'costo' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false,
                'default' => 0,
            ],
            'descripcion' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'activo' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
                'default' => 1,
            ],
            'orden' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                'default' => 1,
            ],
            'fecha_creacion' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'fecha_actualizacion' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('nombre');
        $this->forge->createTable('tarifas_envio');

        // Insertar tarifas por defecto
        $this->db->table('tarifas_envio')->insertBatch([
            [
                'nombre' => 'Envío Local (0-1 km)',
                'distancia_minima' => 0,
                'distancia_maxima' => 1.0,
                'costo' => 0,
                'descripcion' => 'Envío gratuito para distancias hasta 1 km',
                'activo' => 1,
                'orden' => 1,
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'fecha_actualizacion' => date('Y-m-d H:i:s'),
            ],
            [
                'nombre' => 'Envío Local (1-2 km)',
                'distancia_minima' => 1.0,
                'distancia_maxima' => 2.0,
                'costo' => 500,
                'descripcion' => 'Envío local para distancias entre 1 y 2 km',
                'activo' => 1,
                'orden' => 2,
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'fecha_actualizacion' => date('Y-m-d H:i:s'),
            ],
            [
                'nombre' => 'Envío Local (2-3 km)',
                'distancia_minima' => 2.0,
                'distancia_maxima' => 3.0,
                'costo' => 1000,
                'descripcion' => 'Envío local para distancias entre 2 y 3 km',
                'activo' => 1,
                'orden' => 3,
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'fecha_actualizacion' => date('Y-m-d H:i:s'),
            ],
            [
                'nombre' => 'Envío Local (3-5 km)',
                'distancia_minima' => 3.0,
                'distancia_maxima' => 5.0,
                'costo' => 1500,
                'descripcion' => 'Envío local para distancias entre 3 y 5 km',
                'activo' => 1,
                'orden' => 4,
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'fecha_actualizacion' => date('Y-m-d H:i:s'),
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('tarifas_envio');
    }
}
