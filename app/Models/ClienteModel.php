<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table            = 'clientes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'nome_completo',
        'email',
        'cpf_cnpj',
        'telefone',
        'logradouro',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'data_nascimento'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
 
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

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
        return $builder->paginate(15);
    }
    /**
     * Retorna a contagem de novos clientes por mês para um gráfico.
     */
     public function getNewClientsPerMonth(): array
    {
        return $this->select("COUNT(id) as count, DATE_FORMAT(created_at, '%Y-%m') as mes")
            ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-6 months')))
            ->groupBy('mes')
            ->orderBy('mes', 'ASC')
            ->findAll();
    }


    protected function _cleanData(array $data): array
    {
        // Verifica se os dados que queremos limpar foram enviados
        if (isset($data['data']['cpf_cnpj'])) {
            // Remove tudo que não for número
            $data['data']['cpf_cnpj'] = preg_replace('/\D/', '', $data['data']['cpf_cnpj']);
        }
        if (isset($data['data']['telefone'])) {
            $data['data']['telefone'] = preg_replace('/\D/', '', $data['data']['telefone']);
        }
        if (isset($data['data']['cep'])) {
            $data['data']['cep'] = preg_replace('/\D/', '', $data['data']['cep']);
        }

        // Converte a data do formato BR (dd/mm/aaaa) para o formato do banco (aaaa-mm-dd)
        if (isset($data['data']['data_nascimento'])) {
            $date = \DateTime::createFromFormat('d/m/Y', $data['data']['data_nascimento']);
            if ($date) {
                $data['data']['data_nascimento'] = $date->format('Y-m-d');
            }
        }

        return $data;
    }


    /**
     * Regras de validação que serão usadas antes de salvar no banco.
     */
    protected $validationRules = [
        'id'            => 'permit_empty|is_natural_no_zero',
        'nome_completo' => 'required|min_length[3]|max_length[255]',
        'email'         => 'required|valid_email|is_unique[clientes.email,id,{id}]',
        'cpf_cnpj'      => 'required|is_unique[clientes.cpf_cnpj,id,{id}]|min_length[11]|max_length[18]',
    ];

    /**
     * Mensagens de erro personalizadas para as regras de validação.
     */
    protected $validationMessages = [
        'email' => [
            'required'    => 'O campo E-mail é obrigatório.',
            'valid_email' => 'Por favor, insira um endereço de e-mail válido.',
            'is_unique'   => 'Este e-mail já está cadastrado em nosso sistema.',
        ],
        'cpf_cnpj' => [
            'required'  => 'O campo CPF/CNPJ é obrigatório.',
            'is_unique' => 'Este CPF/CNPJ já está cadastrado em nosso sistema.',
        ],
    ];
}
