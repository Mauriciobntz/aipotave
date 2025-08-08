<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOrdenToCategorias extends Migration
{
    public function up()
    {
        $this->forge->addColumn('categorias', [
            'orden' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'after' => 'activo'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('categorias', 'orden');
    }
} 