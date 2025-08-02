<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameClientIdInFaturas extends Migration
{
    public function up()
    {
        $fields = [
            // Coluna antiga ('client_id')
            'client_id' => [
                // Novo nome e redefinição das propriedades
                'name'       => 'cliente_id',
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => false,
            ],
        ];

        $this->forge->modifyColumn('faturas', $fields);
    }

    public function down()
    {
        // O processo inverso para o caso de rollback
        $fields = [
            'cliente_id' => [
                'name'       => 'client_id',
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => false,
            ],
        ];
        $this->forge->modifyColumn('faturas', $fields);
    }
}