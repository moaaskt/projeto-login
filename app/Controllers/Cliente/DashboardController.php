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
     */
    public function dashboard()
    {
        // Na próxima etapa, vamos preencher isso com dados reais do banco.
        // Por enquanto, definimos a estrutura que a view espera.
        $data = [
            'titulo' => 'Meu Dashboard',
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
            'monthly_revenue' => [
                'categories' => ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                'series' => ['name' => 'Valor Pago', 'data' => [0, 0, 0, 0, 0, 0]]
            ],
            'ultimas_faturas' => [],
        ];

        // Carrega a view da dashboard que vamos criar no próximo passo.
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
     * Exibe a página de perfil do cliente.
     */
    public function perfil()
    {
        // TODO: Mover a lógica de perfil para cá.
        // Por enquanto, apenas carregamos a view que você já tem.
        $data['titulo'] = 'Meu Perfil';
        return view('cliente/perfil', $data);
    }
}
