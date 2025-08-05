<?php

namespace App\Repositories;

use App\Models\FaturaModel;

class FaturaRepository
{
    /**
     * @var FaturaModel
     */
    private $faturaModel;

    public function __construct()
    {
        $this->faturaModel = new FaturaModel();
    }

    /**
     * Adiciona uma nova fatura no banco de dados.
     */
    public function criarFatura(array $dados)
    {
        return $this->faturaModel->insert($dados);
    }

    /**
     * Atualiza uma fatura existente.
     */
    public function atualizarFatura(int $idFatura, array $dados)
    {
        return $this->faturaModel->update($idFatura, $dados);
    }

    /**
     * Busca uma fatura pelo seu ID.
     */
    public function getFaturaPorId(int $idFatura)
    {
        return $this->faturaModel->find($idFatura);
    }

    /**
     * Retorna todas as faturas de um determinado cliente.
     */
    public function getFaturasPorCliente(int $idCliente)
    {
        return $this->faturaModel->where('cliente_id', $idCliente)->findAll();
    }

    /**
     * Busca faturas por um intervalo de data de vencimento.
     */
    public function getFaturasPorVencimento(string $dataInicio, string $dataFim)
    {
        return $this->faturaModel
            ->where('data_vencimento >=', $dataInicio)
            ->where('data_vencimento <=', $dataFim)
            ->findAll();
    }

    /**
     * Busca faturas pagas em um determinado intervalo de datas.
     */
    public function getFaturasPagasPorData(string $dataInicio, string $dataFim)
    {
        return $this->faturaModel
            ->where('status', 'paga') // Supondo que o status seja 'paga'
            ->where('data_pagamento >=', $dataInicio)
            ->where('data_pagamento <=', $dataFim)
            ->findAll();
    }

    /**
     * Busca faturas com um determinado status (ex: 'pendente', 'paga', 'cancelada').
     */
    public function getFaturasPorStatus(string $status)
    {
        return $this->faturaModel->where('status', $status)->findAll();
    }
    
    /**
     * Calcula o valor total de faturas dentro de um intervalo de datas.
     * Útil para relatórios de dashboard.
     */
    public function getTotalFaturadoPorPeriodo(string $dataInicio, string $dataFim)
    {
        return $this->faturaModel
            ->selectSum('valor') // Seleciona a SOMA da coluna 'valor'
            ->where('data_vencimento >=', $dataInicio)
            ->where('data_vencimento <=', $dataFim)
            ->first()['valor']; // Pega apenas o valor da soma
    }
}
