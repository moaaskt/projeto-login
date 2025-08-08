<?php

namespace App\Controllers\Cliente;

use App\Controllers\BaseController;

/**
 * Controla todas as páginas da área logada do cliente.
 */
class DashboardController extends BaseController
{
  /**
     * Exibe a nova dashboard com gráficos e estatísticas.
     * VERSÃO FINAL COM DADOS REAIS
     */
    public function dashboard()
    {
        // 1. Instanciar o FaturaModel
        $faturaModel = new \App\Models\FaturaModel();

        // 2. Pegar o ID do cliente da sessão
        $clienteId = session()->get('usuario')['id'];

        // 3. Chamar o novo método do model para obter todos os dados da dashboard
        $dashboardData = $faturaModel->getDashboardDataForClient($clienteId);

        // 4. Montar o array de dados final para a view
        $data = [
            'titulo'              => 'Meu Dashboard',
            'stats'               => $dashboardData['stats'],
            'status_distribution' => $dashboardData['status_distribution'],
            'monthly_revenue'     => $dashboardData['monthly_revenue'],
        ];

        // 5. Carregar a view, que agora receberá os dados processados
        return view('cliente/dashboard', $data);
    }

    /**
     * Exibe a lista de faturas do cliente.
     */
    /**
     * Exibe a lista de faturas do cliente.
     * VERSÃO COMPLETA E FUNCIONAL
     */
    public function faturas()
    {
        // 1. Instanciar o Model que busca as faturas
        $faturaModel = new \App\Models\FaturaModel();

        // 2. Pegar o ID do cliente da sessão.
        //    A sua sessão salva os dados dentro de um array 'usuario'.
        $clienteId = session()->get('usuario')['id'];

        // 3. Montar o array de dados para a view
        $data = [
            'title'   => 'Minhas Faturas',
            // 4. Buscar as faturas ONDE o 'cliente_id' é o do usuário logado
            'faturas' => $faturaModel->where('cliente_id', $clienteId)
                ->orderBy('data_vencimento', 'DESC')
                ->findAll()
        ];

        // 5. Carregar a view, agora com os dados das faturas
        return view('cliente/faturas/index', $data);
    }


    public function visualizar($faturaId)
    {
        // 1. Instanciar o Model de Faturas
        $faturaModel = new \App\Models\FaturaModel();

        // 2. Pegar o ID do cliente logado na sessão (para segurança)
        $clienteId = session()->get('usuario')['id'];

        // 3. Buscar a fatura no banco de dados com uma condição dupla:
        //    - O ID da fatura deve ser o da URL.
        //    - O cliente_id deve ser o do usuário logado.
        //    Isso impede que um cliente veja a fatura de outro!
        $fatura = $faturaModel->where('id', $faturaId)
            ->where('cliente_id', $clienteId)
            ->first();

        // 4. Se a fatura não for encontrada (ou não pertencer ao cliente), mostra erro 404.
        if (!$fatura) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Fatura não encontrada ou não pertence a você.');
        }

        // 5. Monta os dados e carrega a view de visualização.
        $data = [
            'title'  => 'Detalhes da Fatura #' . $fatura['id'],
            'fatura' => $fatura
        ];

        return view('cliente/faturas/visualizar', $data);
    }



  /**
     * Exibe a página de perfil do cliente com seus dados.
     * VERSÃO COMPLETA E FUNCIONAL
     */
    public function perfil()
    {
        // 1. Instanciar o Model de Usuários
        $usuarioModel = new \App\Models\UsuarioModel();

        // 2. Pegar o ID do usuário logado na sessão
        $usuarioId = session()->get('usuario')['id'];

        // 3. Montar o array de dados para a view
        $data = [
            'title'   => 'Meu Perfil',
            // 4. Buscar os dados do usuário no banco e passá-los para a view
            'usuario' => $usuarioModel->find($usuarioId)
        ];
        
        // 5. Carregar a view de perfil, agora com os dados do usuário
        return view('cliente/perfil', $data);
    }
}
