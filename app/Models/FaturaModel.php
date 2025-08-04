<?php

namespace App\Models;

use CodeIgniter\Model;

class FaturaModel extends Model
{
    protected $table            = 'faturas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;

    // AQUI ESTÁ A CORREÇÃO PRINCIPAL
    protected $allowedFields = [
        'cliente_id',       // Nome padronizado
        'descricao',
        'valor',
        'data_vencimento',  // Nome padronizado
        'data_pagamento',
        'status',
        'fatura_id',
        'comprovantes',
    ];

    // Timestamps
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}