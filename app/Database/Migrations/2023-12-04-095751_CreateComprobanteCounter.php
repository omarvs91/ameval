<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateComprobanteCounter extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'tipo_comprobante' => [
                'type' => 'CHAR',
                'constraint' => '1',
            ],
            'last_value' => [
                'type' => 'INT',
                'null' => FALSE,
            ],
        ]);

        $this->forge->addKey('tipo_comprobante', TRUE);

        $this->forge->createTable('comprobante_counter');

        // Insert initial data
        $this->db->table('comprobante_counter')->insert(['tipo_comprobante' => 'N', 'last_value' => 0]);
        $this->db->table('comprobante_counter')->insert(['tipo_comprobante' => 'B', 'last_value' => 0]);
        $this->db->table('comprobante_counter')->insert(['tipo_comprobante' => 'F', 'last_value' => 0]);
    }

    public function down()
    {
        $this->forge->dropTable('comprobante_counter');
    }
}
