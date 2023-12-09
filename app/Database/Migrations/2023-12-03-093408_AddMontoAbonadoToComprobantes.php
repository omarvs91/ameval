<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMontoAbonadoToComprobantes extends Migration
{
    public function up()
    {
        $fields = [
            'monto_abonado' => [
                'type' => 'FLOAT',
                'null' => TRUE // the column after which the new column will be added
            ]
        ];

        $this->forge->addColumn('comprobantes', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('comprobantes', 'monto_abonado');
    }
}
