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

        // --- PREPARAÇÃO COMPLETA DE DADOS ---

        // Dados para Gráfico de Status
        $statusData = $faturaModel->getStatusDistribution() ?? [];
        $statusLabels = [];
        $statusSeries = [];
        foreach ($statusData as $status) {
            $statusLabels[] = $status['status'];
            $statusSeries[] = (int)$status['count'];
        }

        // Dados para Gráfico Comparativo
        $labels = [];
        for ($i = 5; $i >= 0; $i--) {
            $labels[] = date("Y-m", strtotime("-$i months"));
        }
        $revenueSeries = array_fill_keys($labels, 0);
        $billedSeries = array_fill_keys($labels, 0);
        $clientSeries = array_fill_keys($labels, 0);

        $monthlyRevenueData = $faturaModel->getMonthlyRevenue() ?? [];
        $monthlyBilledData = $faturaModel->getMonthlyBilled() ?? [];
        $newClientsData = $clienteModel->getNewClientsPerMonth() ?? [];
        
        foreach ($monthlyRevenueData as $row) {
            if (isset($revenueSeries[$row['mes']])) { $revenueSeries[$row['mes']] = (float)$row['total']; }
        }
        foreach ($monthlyBilledData as $row) {
            if (isset($billedSeries[$row['mes']])) { $billedSeries[$row['mes']] = (float)$row['total']; }
        }
        foreach ($newClientsData as $row) {
            if (isset($clientSeries[$row['mes']])) { $clientSeries[$row['mes']] = (int)$row['count']; }
        }
        
        $chartLabels = array_map(fn($mes) => date('M/Y', strtotime($mes)), $labels);

        // Montagem final do array de dados
        $data = [
            'email'          => $this->usuarioData['email'],
            'title'          => 'Dashboard Principal',
            'stats'          => $faturaModel->getDashboardStatistics(),
            'statusLabels'   => json_encode($statusLabels),
            'statusSeries'   => json_encode($statusSeries),
            'clientLabels'   => json_encode($chartLabels), // Usando o label de meses unificado
            'clientSeries'   => json_encode(array_values($clientSeries)),
            'revenueLabels'  => json_encode($chartLabels), // Usando o label de meses unificado
            'billedSeries'   => json_encode(array_values($billedSeries)),
            'revenueSeries'  => json_encode(array_values($revenueSeries)),

             'chartLabels'    => json_encode($chartLabels),
        ];

        return view('painel/dashboard/index', $data);
    }
    
    // Todos os outros métodos (faturas, clientes, perfil, etc.) foram movidos para seus controllers
    // Se ainda estiverem aqui, apague-os. O DashboardController deve ter apenas o index() e o __construct().
    // Vou deixá-los aqui por enquanto, caso você não tenha criado os outros controllers.
    
    // --- MÉTODOS DE PERFIL ---
    public function perfil()
    {
        $data = ['title' => 'Meu Perfil'];
        return view('painel/perfil/index', $data);
    }
}