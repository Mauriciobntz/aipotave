<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCostoEnvioToPedidos extends Migration
{
    public function up()
    {
        // Agregar campo costo_envio a la tabla pedidos
        $this->forge->addColumn('pedidos', [
            'costo_envio' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false,
                'default' => 0.00,
                'after' => 'total'
            ]
        ]);
    }

    public function down()
    {
        // Remover campo costo_envio de la tabla pedidos
        $this->forge->dropColumn('pedidos', 'costo_envio');
    }
}
