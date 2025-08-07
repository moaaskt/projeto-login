<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleToUsuarios extends Migration
{
    public function up()
    {
        $this->forge->addColumn('usuarios', [
            'role' => [
                'type'       => "ENUM('admin', 'cliente')",
                'default'    => 'cliente',
                'null'       => false,
                'after'      => 'senha',
            ],
            'cliente_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true, // Nulo para admins
                'after'      => 'role',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('usuarios', ['role', 'cliente_id']);
    }
}