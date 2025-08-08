<?php

namespace App\Controllers\painel;

use App\Controllers\BaseController;
use App\Models\FaturaModel;

class PortalController extends BaseController
{
    protected $session;
    protected $usuarioData;
    protected $clienteId;


    /**     * Construtor para inicializar dados do usuário e cliente
     */

    public function __construct()
    {
        $this->session = session();
        $this->usuarioData = $this->session->get('usuario');
        $this->clienteId = $this->usuarioData['cliente_id'] ?? null;
    }

    /**
     * Dashboard do Cliente
     */
    public function index()
    {
        $faturaModel = new FaturaModel();
        
       
        $data = [
            'title' => 'Meu Portal',
            'stats' => $faturaModel->where('cliente_id', $this->clienteId)->getDashboardStatistics(),
            // ... (preparar dados de gráficos filtrados) ...
        ];
        
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
        // Renderiza a view com as faturas filtradas
        return view('painel/portal/faturas', $data);
    }
}