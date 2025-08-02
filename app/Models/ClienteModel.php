<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table            = 'clientes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true; // Ativa a "lixeira"
    protected $protectFields    = true;

  protected $allowedFields    = [
        'nome_completo', // <-- O campo que estava faltando
        'cpf_cnpj',
        'email',
        'telefone',
        'endereco',
        'cep',
        'data_nascimento',
    ];

    // Dates
    protected $useTimestamps = true; // Gerencia created_at e updated_at
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation (opcional)
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}