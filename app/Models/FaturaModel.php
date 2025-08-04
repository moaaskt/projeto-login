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



    public function search($filters = [])
    {
        // Inicia o Query Builder já com o JOIN que sempre precisamos
        $builder = $this->select('faturas.*, clientes.nome_completo as nome_cliente')
            ->join('clientes', 'clientes.id = faturas.cliente_id', 'left');

        // Filtro por status
        if (!empty($filters['status'])) {
            $builder->where('faturas.status', $filters['status']);
        }

        // Filtro por valor mínimo
        if (!empty($filters['valor_min'])) {
            $builder->where('faturas.valor >=', $filters['valor_min']);
        }

        // Filtro por valor máximo
        if (!empty($filters['valor_max'])) {
            $builder->where('faturas.valor <=', $filters['valor_max']);
        }

        // Filtro por período de data de vencimento
        if (!empty($filters['data_inicio'])) {
            $builder->where('faturas.data_vencimento >=', $filters['data_inicio']);
        }
        if (!empty($filters['data_fim'])) {
            $builder->where('faturas.data_vencimento <=', $filters['data_fim']);
        }

        // Retorna os resultados paginados
        return $builder->paginate(15);
    }
}
