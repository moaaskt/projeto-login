<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUniqueConstraints extends Migration
{
    public function up()
    {
        // Adiciona restrições UNIQUE à tabela 'usuarios'
        $this->forge->modifyColumn('usuarios', [
            'email' => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'cpf'   => ['type' => 'VARCHAR', 'constraint' => 14, 'null' => true, 'unique' => true],
        ]);

        // Adiciona restrições UNIQUE à tabela 'clientes'
        $this->forge->modifyColumn('clientes', [
            'email'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'unique' => true],
            'cpf_cnpj' => ['type' => 'VARCHAR', 'constraint' => 18, 'null' => true, 'unique' => true],
        ]);
    }

    public function down()
    {
        // Remove as restrições (processo inverso)
        $this->forge->modifyColumn('usuarios', [
            'email' => ['type' => 'VARCHAR', 'constraint' => 255],
            'cpf'   => ['type' => 'VARCHAR', 'constraint' => 14, 'null' => true],
        ]);
        $this->forge->modifyColumn('clientes', [
            'email'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'cpf_cnpj' => ['type' => 'VARCHAR', 'constraint' => 18, 'null' => true],
        ]);
    }
}