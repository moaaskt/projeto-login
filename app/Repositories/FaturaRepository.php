<?php

namespace App\Repositories;

use App\Models\FaturaModel;

// 1. Herda da BaseRepository
class FaturaRepository extends BaseRepository
{
    public function __construct()
    {
        // 2. Define o FaturaModel como o model padrão
        $this->model = new FaturaModel();
    }

    // 3. MANTEMOS APENAS OS MÉTODOS ESPECÍFICOS DE FATURA!
    // Os métodos comuns como find, findAll, create, update, delete
    // já foram herdados.

    public function getFaturasPorCliente(int $idCliente)
    {
        return $this->model->where('cliente_id', $idCliente)->findAll();
    }

    public function getFaturasPorVencimento(string $dataInicio, string $dataFim)
    {
        return $this->model
            ->where('data_vencimento >=', $dataInicio)
            ->where('data_vencimento <=', $dataFim)
            ->findAll();
    }

    public function getFaturasPagasPorData(string $dataInicio, string $dataFim)
    {
        return $this->model
            ->where('status', 'paga')
            ->where('data_pagamento >=', $dataInicio)
            ->where('data_pagamento <=', $dataFim)
            ->findAll();
    }

    public function getFaturasPorStatus(string $status)
    {
        return $this->model->where('status', $status)->findAll();
    }
    
    public function getTotalFaturadoPorPeriodo(string $dataInicio, string $dataFim)
    {
        return $this->model
            ->selectSum('valor')
            ->where('data_vencimento >=', $dataInicio)
            ->where('data_vencimento <=', $dataFim)
            ->first()['valor'];
    }
}
