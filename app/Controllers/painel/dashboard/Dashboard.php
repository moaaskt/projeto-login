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

    // Em app/Controllers/painel/dashboard/Dashboard.php

    public function index()
    {
        if (empty($this->usuarioData)) {
            return redirect()->to(base_url('logout'));
        }

        $faturaModel = new FaturaModel();
        $clienteModel = new ClienteModel();

        // --- PREPARAÇÃO COMPLETA DE DADOS PARA OS GRÁFICOS ---

        // 1. Define a linha do tempo (últimos 6 meses)
        $labels = [];
        for ($i = 5; $i >= 0; $i--) {
            $labels[] = date("Y-m", strtotime("-$i months"));
        }

        // 2. Cria arrays "esqueleto" com zeros
        $revenueSeries = array_fill_keys($labels, 0);
        $billedSeries = array_fill_keys($labels, 0);
        $clientSeries = array_fill_keys($labels, 0);

        // 3. Busca os dados reais do banco
        $monthlyRevenueData = $faturaModel->getMonthlyRevenue() ?? [];
        $monthlyBilledData = $faturaModel->getMonthlyBilled() ?? [];
        $newClientsData = $clienteModel->getNewClientsPerMonth() ?? [];

        // 4. Preenche os arrays com os dados reais
        foreach ($monthlyRevenueData as $row) {
            if (isset($revenueSeries[$row['mes']])) {
                $revenueSeries[$row['mes']] = (float)$row['total'];
            }
        }
        foreach ($monthlyBilledData as $row) {
            if (isset($billedSeries[$row['mes']])) {
                $billedSeries[$row['mes']] = (float)$row['total'];
            }
        }
        foreach ($newClientsData as $row) {
            if (isset($clientSeries[$row['mes']])) {
                $clientSeries[$row['mes']] = (int)$row['count'];
            }
        }

        $chartLabels = array_map(fn($mes) => date('M/Y', strtotime($mes)), $labels);

        // 5. Monta o array final e completo para a View
        $data = [
            'email'          => $this->usuarioData['email'],
            'title'          => 'Dashboard Principal',
            'stats'          => $faturaModel->getDashboardStatistics(),
            'chartLabels'    => json_encode($chartLabels),
            'revenueSeries'  => json_encode(array_values($revenueSeries)),
            'billedSeries'   => json_encode(array_values($billedSeries)), // <-- GARANTIDO QUE ESTÁ AQUI
            'clientSeries'   => json_encode(array_values($clientSeries)),
        ];

        return view('painel/dashboard/index', $data);
    }

    
    public function perfil()
    {

        $data = ['title' => 'Meu Perfil'];
        return view('painel/perfil/index', $data);
    }
}
