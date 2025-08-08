<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AgregarOrigenHistorialEstados extends Migration
{
    public function up()
    {
        $this->forge->addColumn('historial_estados', [
            'origen' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'fecha_cambio'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('historial_estados', 'origen');
    }
}
