<?php

namespace App\Controllers\painel\dashboard;

use App\Controllers\BaseController;
use App\Models\ClienteModel;
use App\Models\FaturaModel;


class Dashboard extends BaseController
{
    protected $session;
    protected $usuarioData;

    public function __construct()
    {
        $this->session = session();
        $this->usuarioData = $this->session->get('usuario');
    }

    public function index()
    {
        if (empty($this->usuarioData)) {
            return redirect()->to(base_url('logout'));
        }

        $faturaModel = new FaturaModel();
        $clienteModel = new ClienteModel();

        // 1. Prepara dados para o gráfico de Status (Donut)
        $statusData = $faturaModel->getStatusDistribution();
        $statusLabels = [];
        $statusSeries = [];
        foreach ($statusData as $status) {
            $statusLabels[] = $status['status'];
            $statusSeries[] = (int)$status['count'];
        }

        // 2. Prepara dados para o gráfico de Novos Clientes (Barras)
        $newClientsData = $clienteModel->getNewClientsPerMonth();
        $clientLabels = [];
        $clientSeries = [];
        foreach ($newClientsData as $client) {
            $clientLabels[] = date('M/Y', strtotime($client['mes']));
            $clientSeries[] = (int)$client['count'];
        }

        // 3. Prepara dados para o gráfico de Faturamento (Colunas)
        $monthlyRevenueData = $faturaModel->getMonthlyRevenue();
        $revenueLabels = [];
        $revenueSeries = [];
        foreach ($monthlyRevenueData as $revenue) {
            $revenueLabels[] = date('M/Y', strtotime($revenue['mes']));
            $revenueSeries[] = (float)$revenue['total'];
        }

        // 4. Monta o array final de dados para a View
        $data = [
            'email'              => $this->usuarioData['email'],
            'title'              => 'Dashboard Principal',
            'stats'              => $faturaModel->getDashboardStatistics(),
            'statusLabels'       => json_encode($statusLabels),
            'statusSeries'       => json_encode($statusSeries),
            'clientLabels'       => json_encode($clientLabels),
            'clientSeries'       => json_encode($clientSeries),
            'revenueLabels'      => json_encode($revenueLabels),
            'revenueSeries'      => json_encode($revenueSeries),
        ];

        return view('painel/dashboard/index', $data);
    }

    
    public function perfil()
    {

        $data = ['title' => 'Meu Perfil'];
        return view('painel/perfil/index', $data);
    }
}
