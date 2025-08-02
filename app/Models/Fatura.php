<?php

namespace App\Models;

use CodeIgniter\Model;

class Fatura extends Model
{
    protected $table            = 'faturas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'client_id',
        'descricao',
        'valor',
        'vencimento',
        'data_pagamento',
        'status',
        'fatura_id',
        'comprovantes',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Timestamps
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation (opcional)
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    // Callbacks (opcional)
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
