<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableClientes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'unsigned'       => true,
            ],
            'nome' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'cpf_cnpj' => [
                'type'       => 'VARCHAR',
                'constraint' => '18', // Acomoda tanto CPF quanto CNPJ com máscara
                'null'       => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'telefone' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'endereco' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'cep' => [
                'type'       => 'VARCHAR',
                'constraint' => '9',
                'null'       => true,
            ],
            'data_nascimento' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('clientes');
    }

    public function down()
    {
        $this->forge->dropTable('clientes');
    }
}