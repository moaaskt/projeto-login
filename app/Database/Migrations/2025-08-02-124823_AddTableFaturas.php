<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableFaturas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'unsigned'       => true,
            ],
            'client_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => false,
            ],
            'descricao' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'valor' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
            'vencimento' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'data_pagamento' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => false,
                'default'    => 'pendente', // exemplo: pendente, pago, cancelado
            ],
            'fatura_id' => [
                'type'     => 'VARCHAR',
                'constraint' => '100',
                'null'     => true,
            ],
            'comprovantes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'deleted_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id', true); // PK
        $this->forge->addForeignKey('client_id', 'clientes', 'id', 'CASCADE', 'CASCADE'); // Opcional
        $this->forge->createTable('faturas');
    }

    public function down()
    {
        $this->forge->dropTable('faturas');
    }
}
