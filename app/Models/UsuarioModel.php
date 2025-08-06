<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;


    protected $allowedFields    = [
        'nome',
        'email',
        'telefone',
        'cpf',
        'endereco',
        'cep',
        'senha',
    ];

    protected $beforeInsert = ['_cleanUserData'];
    protected $beforeUpdate = ['_cleanUserData'];


    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;



     protected function _cleanUserData(array $data): array
    {
        if (isset($data['data']['cpf'])) {
            $data['data']['cpf'] = preg_replace('/\D/', '', $data['data']['cpf']);
        }
        if (isset($data['data']['telefone'])) {
            $data['data']['telefone'] = preg_replace('/\D/', '', $data['data']['telefone']);
        }
        if (isset($data['data']['cep'])) {
            $data['data']['cep'] = preg_replace('/\D/', '', $data['data']['cep']);
        }
        
        return $data;
    }




}
