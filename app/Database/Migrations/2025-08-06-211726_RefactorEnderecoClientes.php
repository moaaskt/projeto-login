<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RefactorEnderecoClientes extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('clientes', 'endereco');
        $this->forge->addColumn('clientes', [
            'logradouro' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'telefone'],
            'numero'     => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true, 'after' => 'logradouro'],
            'bairro'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true, 'after' => 'numero'],
            'cidade'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true, 'after' => 'bairro'],
            'estado'     => ['type' => 'VARCHAR', 'constraint' => 2, 'null' => true, 'after' => 'cidade'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('clientes', ['logradouro', 'numero', 'bairro', 'cidade', 'estado']);
        $this->forge->addColumn('clientes', [
            'endereco' => ['type' => 'TEXT', 'null' => true, 'after' => 'telefone'],
        ]);
    }
}