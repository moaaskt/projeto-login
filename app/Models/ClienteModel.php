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


    /**
     * Busca clientes no banco de dados com base nos filtros.
     *
     * @param array $filters Filtros de busca
     * @return array Lista de clientes
     */
    public function search($filters = [])
    {
        // Inicia o Query Builder
        $builder = $this->table('clientes');

        // Filtro por termo de busca (nome, email, cpf_cnpj, telefone)
        // Usamos groupStart() para agrupar as condições com OR
        if (!empty($filters['termo'])) {
            $termo = $filters['termo'];
            $builder->groupStart()
                ->like('nome_completo', $termo)
                ->orLike('email', $termo)
                ->orLike('cpf_cnpj', $termo)
                ->orLike('telefone', $termo)
                ->groupEnd();
        }

        // Filtro por data de cadastro
        // Comparamos apenas a parte da DATA da coluna created_at
        if (!empty($filters['data_cadastro'])) {
            $builder->where('DATE(created_at)', $filters['data_cadastro']);
        }

        // Retorna todos os resultados que correspondem aos filtros
        return $builder->findAll();
    }
}
