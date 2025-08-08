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
        $builder = $this->select('faturas.*, usuarios.nome as nome_cliente')
            ->join('usuarios', 'usuarios.id = faturas.cliente_id', 'left');

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

    /**
     * Calcula e retorna as estatísticas das faturas para o dashboard.
     * Retorna contagem e soma total, e também agrupado por status.
     *
     * @return array
     */
    public function getDashboardStatistics()
    {
        // 1. Clona o model para evitar conflitos com outros usos
        $modelClone = clone $this;

        // 2. Totais gerais
        $totals = $modelClone
            ->select('COUNT(id) as total_count, SUM(valor) as total_sum')
            ->first();

        // 3. Totais por status
        $byStatus = $this->select('status, COUNT(id) as count, SUM(valor) as sum')
            ->groupBy('status')
            ->findAll();

        // 4. Inicializa estrutura padronizada
        $statuses = ['Paga', 'Pendente', 'Vencida', 'Cancelada'];
        $statistics = [
            'total' => [
                'count' => (int)($totals['total_count'] ?? 0),
                'sum'   => (float)($totals['total_sum'] ?? 0),
            ],
        ];

        foreach ($statuses as $status) {
            $statistics[$status] = ['count' => 0, 'sum' => 0];
        }

        // 5. Preenche os valores de acordo com o que veio do banco
        foreach ($byStatus as $row) {
            $status = ucfirst(strtolower($row['status'])); // normaliza: 'paga' -> 'Paga'

            if (array_key_exists($status, $statistics)) {
                $statistics[$status] = [
                    'count' => (int)$row['count'],
                    'sum'   => (float)$row['sum'],
                ];
            }
        }

        return $statistics;
    }


    /**
     * Retorna o faturamento (soma de faturas pagas) por mês para um gráfico.
     */
    public function getMonthlyRevenue()
    {
        return $this->select("SUM(valor) as total, DATE_FORMAT(data_pagamento, '%Y-%m') as mes")
            ->where('status', 'Paga')
            ->where('data_pagamento IS NOT NULL')
            ->groupBy("DATE_FORMAT(data_pagamento, '%Y-%m')")
            ->orderBy("mes", "ASC")
            ->findAll();
    }

    /**
     * Retorna a contagem de faturas para cada status.
     */
    public function getStatusDistribution()
    {
        return $this->select('status, COUNT(id) as count')
            ->groupBy('status')
            ->findAll();
    }


    /**
     * Retorna o valor total emitido (todas as faturas) por mês.
     */
    public function getMonthlyBilled()
    {
        return $this->select("SUM(valor) as total, DATE_FORMAT(created_at, '%Y-%m') as mes")
            ->groupBy("DATE_FORMAT(created_at, '%Y-%m')")
            ->orderBy("mes", "ASC")
            ->findAll();
    }



    /**
     * Calcula e retorna todos os dados necessários para a dashboard de um cliente específico.
     *
     * @param integer $clienteId O ID do cliente.
     * @return array              Array com 'stats', 'status_distribution' e 'monthly_revenue'.
     */
    public function getDashboardDataForClient(int $clienteId): array
    {
        // --- 1. Buscar estatísticas básicas (Contagem e Soma por Status) ---
        // Esta única consulta nos dará dados para os cards e para o gráfico de donut.
        $statsByStatus = $this->select('status, COUNT(id) as count, SUM(valor) as sum')
            ->where('cliente_id', $clienteId)
            ->groupBy('status')
            ->findAll();

        // --- 2. Preparar a estrutura de dados de saída ---
        $result = [
            'stats' => [
                'total_faturas' => 0,
                'total_pago' => 0,
                'total_pendente' => 0,
                'total_vencido' => 0
            ],
            'status_distribution' => [
                'labels' => ['Pagas', 'Pendentes', 'Vencidas', 'Canceladas'],
                'data'   => [0, 0, 0, 0]
            ],
        ];

        // Mapeamento para o array de dados do gráfico de donut
        $statusMap = ['Paga' => 0, 'Pendente' => 1, 'Vencida' => 2, 'Cancelada' => 3];

        // --- 3. Processar os resultados da consulta ---
        foreach ($statsByStatus as $row) {
            $status = ucfirst(strtolower($row['status'])); // Normaliza 'PAGA' ou 'paga' para 'Paga'

            // Preenche os dados dos cards de KPI
            if ($status === 'Paga') $result['stats']['total_pago'] = (float)$row['sum'];
            if ($status === 'Pendente') $result['stats']['total_pendente'] = (float)$row['sum'];
            if ($status === 'Vencida') $result['stats']['total_vencido'] = (float)$row['sum'];

            // Soma a contagem total de faturas
            $result['stats']['total_faturas'] += (int)$row['count'];

            // Preenche os dados do gráfico de donut
            if (isset($statusMap[$status])) {
                $result['status_distribution']['data'][$statusMap[$status]] = (int)$row['count'];
            }
        }

        // --- 4. Buscar receita mensal (Faturas Pagas nos últimos 6 meses) ---
        $sixMonthsAgo = date('Y-m-d', strtotime('-6 months'));
        $monthlyData = $this->select("SUM(valor) as total, DATE_FORMAT(data_pagamento, '%Y-%m') as mes")
            ->where('cliente_id', $clienteId)
            ->where('status', 'Paga')
            ->where('data_pagamento >=', $sixMonthsAgo)
            ->groupBy('mes')
            ->orderBy('mes', 'ASC')
            ->findAll();

        // --- 5. Preparar dados para o gráfico de área (garantindo todos os 6 meses) ---
        $revenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthKey = date('Y-m', strtotime("-$i months"));
            $monthLabel = date('M', strtotime("-$i months")); // 'M' para abreviação: 'Jan', 'Fev'
            $revenue[$monthKey] = ['label' => $monthLabel, 'total' => 0];
        }

        foreach ($monthlyData as $row) {
            if (isset($revenue[$row['mes']])) {
                $revenue[$row['mes']]['total'] = (float)$row['total'];
            }
        }

        $result['monthly_revenue'] = [
            'categories' => array_column($revenue, 'label'),
            'series'     => [
                'name' => 'Valor Pago',
                'data' => array_column($revenue, 'total')
            ]
        ];

        return $result;
    }
}
