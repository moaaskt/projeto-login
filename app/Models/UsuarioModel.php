<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{

    // Define o nome da tabela e outras propriedades do Model
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    // Define os campos que podem ser preenchidos
    protected $allowedFields    = [
        'nome',
        'email',
        'cpf',
        'telefone',
        'cep',
        'endereco',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'senha',
        'role',
        'cliente_id', 
        'reset_token',
        'reset_expires',
        'must_change_password'
    ];



    // Define os eventos do Model
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

   
   
    // Define os métodos de validação
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
