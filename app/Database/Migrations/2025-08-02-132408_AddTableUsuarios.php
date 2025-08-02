<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableUsuarios extends Migration
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
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'unique'     => true, // Garante que não haverá e-mails repetidos
            ],
            'telefone' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'cpf' => [
                'type'       => 'VARCHAR',
                'constraint' => '14',
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
            'senha' => [
                'type'       => 'VARCHAR',
                'constraint' => '255', // Para armazenar o hash da senha
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

        $this->forge->addKey('id', true); // Define 'id' como Chave Primária
        $this->forge->createTable('usuarios');
    }

    public function down()
    {
        $this->forge->dropTable('usuarios');
    }
}