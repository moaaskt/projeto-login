<?php

namespace App\Controllers\painel;

use App\Controllers\BaseController;
use App\Models\FaturaModel;

class PortalController extends BaseController
{
    protected $session;
    protected $usuarioData;
    protected $clienteId;

    public function __construct()
    {
        $this->session = session();
        $this->usuarioData = $this->session->get('usuario');
        // A "mágica" acontece aqui: pegamos o ID do cliente associado ao usuário logado
        $this->clienteId = $this->usuarioData['cliente_id'] ?? null;
    }

    /**
     * Dashboard do Cliente
     */
    public function index()
    {
        $faturaModel = new FaturaModel();
        
        // Exemplo: os dados dos gráficos agora são filtrados pelo cliente
        $data = [
            'title' => 'Meu Portal',
            'stats' => $faturaModel->where('cliente_id', $this->clienteId)->getDashboardStatistics(),
            // ... (preparar dados de gráficos filtrados) ...
        ];
        // Você precisará criar uma nova view para o dashboard do cliente
        return view('painel/portal/dashboard', $data);
    }

    /**
     * Faturas do Cliente
     */
    public function faturas()
    {
        $faturaModel = new FaturaModel();
        
        $data = [
            'title'   => 'Minhas Faturas',
            // A busca de faturas agora é filtrada automaticamente
            'faturas' => $faturaModel->where('cliente_id', $this->clienteId)->search($this->request->getGet()),
            'pager'   => $faturaModel->pager
        ];
        // Você pode criar uma nova view ou adaptar a existente
        return view('painel/portal/faturas', $data);
    }
}