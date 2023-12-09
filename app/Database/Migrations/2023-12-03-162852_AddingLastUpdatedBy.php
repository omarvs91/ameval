<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddingLastUpdatedBy extends Migration
{
    public function up()
    {
        $fields = [
            'last_updated_by' => [
                'type' => 'INT',
                'constraint' => 11, // for an INT of length 11
                'null' => TRUE,
            ]
        ];
        
        $this->forge->addColumn('comprobantes', $fields);

        // Adding a foreign key
        $this->db->query('ALTER TABLE comprobantes ADD CONSTRAINT last_updated_by_fk FOREIGN KEY(last_updated_by) REFERENCES users(id);');
    }

    public function down()
    {
        // Dropping the foreign key
        $this->db->query('ALTER TABLE comprobantes DROP FOREIGN KEY last_updated_by_fk;');

        $this->forge->dropColumn('comprobantes', 'last_updated_by');
    }
}
