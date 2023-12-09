<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropCallmebotFromClientes extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('clientes', 'callmebot_api_key');
    }

    public function down()
    {
        //
    }
}
