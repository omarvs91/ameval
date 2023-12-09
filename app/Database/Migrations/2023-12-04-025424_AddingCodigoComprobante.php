<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddingCodigoComprobante extends Migration
{
    public function up()
    {
        $fields = [
            'cod_comprobante' => [
                'type' => 'VARCHAR',
                'constraint' => 32,
                'null' => TRUE
            ]
        ];

        $this->forge->addColumn('comprobantes', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('comprobantes', 'cod_comprobante');
    }
}
