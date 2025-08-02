<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameNomeInClientes extends Migration
{
    public function up()
    {
        $fields = [
            // Coluna antiga ('nome')
            'nome' => [
                // Novo nome e redefinição das propriedades
                'name'       => 'nome_completo',
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
        ];

        // Usamos modifyColumn para alterar a coluna existente
        $this->forge->modifyColumn('clientes', $fields);
    }

    public function down()
    {
        // O processo inverso para o caso de rollback
        $fields = [
            'nome_completo' => [
                'name'       => 'nome',
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
        ];
        $this->forge->modifyColumn('clientes', $fields);
    }
}