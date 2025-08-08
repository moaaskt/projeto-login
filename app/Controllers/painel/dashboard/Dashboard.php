<?php

namespace App\Controllers\painel\dashboard;

use App\Controllers\BaseController;
use App\Models\ClienteModel;
use App\Models\FaturaModel;

class Dashboard extends BaseController
{
    protected $session;
    protected $usuarioData;
    private $faturaModel;
    private $clienteModel;


    /**
     * Construtor para inicializar dados do usuário e cliente
     */
    public function __construct()
    {
        $this->session = session();
        $this->usuarioData = $this->session->get('usuario');
        
        // Instanciamos os models uma única vez aqui
        $this->faturaModel = new FaturaModel();
        $this->clienteModel = new ClienteModel();
    }


    /**
     * Exibe a página principal do dashboard.
     * Verifica se o usuário está logado e prepara os dados necessários.
     */
   
    public function index()
    {
        if (empty($this->usuarioData)) {
            return redirect()->to(base_url('logout'));
        }

        // Monta o array de dados para a View, chamando os "ajudantes" privados
        $data = [
            'email'           => $this->usuarioData['email'],
            'title'           => 'Dashboard Principal',
            'statusChart'     => $this->_prepareStatusChartData(),
            'clientesChart'   => $this->_prepareNewClientsChartData(),
            'comparisonChart' => $this->_prepareComparisonChartData(),
        ];

        return view('painel/dashboard/index', $data);
    }

    // 

    /**
     * Prepara os dados para o gráfico de Donut (Distribuição de Status).
     */
    private function _prepareStatusChartData(): array
    {
        $statusData = $this->faturaModel->getStatusDistribution() ?? [];
        $labels = [];
        $series = [];
        foreach ($statusData as $status) {
            $labels[] = $status['status'];
            $series[] = (int)$status['count'];
        }
        return [
            'labels' => json_encode($labels),
            'series' => json_encode($series),
        ];
    }

    /**
     * Prepara os dados para o gráfico de Novos Clientes (Gráfico de Área).
     */
    private function _prepareNewClientsChartData(): array
    {
        $labels = [];
        for ($i = 5; $i >= 0; $i--) { $labels[] = date("Y-m", strtotime("-$i months")); }
        
        $clientSeries = array_fill_keys($labels, 0);
        $newClientsData = $this->clienteModel->getNewClientsPerMonth() ?? [];
        foreach ($newClientsData as $row) {
            if (isset($clientSeries[$row['mes']])) {
                $clientSeries[$row['mes']] = (int)$row['count'];
            }
        }
        
        $chartLabels = array_map(fn($mes) => date('M/Y', strtotime($mes)), $labels);
        
        return [
            'categories' => json_encode($chartLabels),
            'series'     => json_encode(array_values($clientSeries)),
        ];
    }
    
    /**
     * Prepara os dados para o gráfico Comparativo Mensal (Gráfico de Colunas).
     */
    private function _prepareComparisonChartData(): array
    {
        $labels = [];
        for ($i = 5; $i >= 0; $i--) { $labels[] = date("Y-m", strtotime("-$i months")); }

        $revenueSeries = array_fill_keys($labels, 0);
        $billedSeries = array_fill_keys($labels, 0);
        $clientSeries = array_fill_keys($labels, 0);

        $monthlyRevenueData = $this->faturaModel->getMonthlyRevenue() ?? [];
        $monthlyBilledData = $this->faturaModel->getMonthlyBilled() ?? [];
        $newClientsData = $this->clienteModel->getNewClientsPerMonth() ?? [];
        
        foreach ($monthlyRevenueData as $row) { if (isset($revenueSeries[$row['mes']])) { $revenueSeries[$row['mes']] = (float)$row['total']; }}
        foreach ($monthlyBilledData as $row) { if (isset($billedSeries[$row['mes']])) { $billedSeries[$row['mes']] = (float)$row['total']; }}
        foreach ($newClientsData as $row) { if (isset($clientSeries[$row['mes']])) { $clientSeries[$row['mes']] = (int)$row['count']; }}
        
        $chartLabels = array_map(fn($mes) => date('M/Y', strtotime($mes)), $labels);

        return [
            'labels'    => json_encode($chartLabels),
            'revenue'  => json_encode(array_values($revenueSeries)),
            'billed'   => json_encode(array_values($billedSeries)),
            'clients'   => json_encode(array_values($clientSeries)),
        ];
    }

   

}