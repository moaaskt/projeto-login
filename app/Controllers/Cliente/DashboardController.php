<?php

namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\FaturaModel;
use App\Repositories\UserRepository;

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



    public function processarPagamentoFicticio()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403, 'Acesso Negado');
        }

        try {
            // Pega o array 'usuario' da sessão
            $usuarioLogado = session()->get('usuario');

            // Validação de segurança: verifica se o usuário está logado e se o array existe
            if (!$usuarioLogado || !isset($usuarioLogado['id'])) {
                throw new \Exception('Sessão inválida. Por favor, faça login novamente.');
            }

            // ## CORREÇÃO APLICADA AQUI ##
            // Pegamos o ID de dentro do array do usuário
            $clienteId = $usuarioLogado['id'];

            $json = $this->request->getJSON();
            $faturaId = $json->fatura_id;

            $faturaModel = new \App\Models\FaturaModel();

            // A validação agora vai funcionar corretamente
            $fatura = $faturaModel->where('id', $faturaId)->where('cliente_id', $clienteId)->first();

            if (!$fatura) {
                throw new \Exception('Fatura inválida ou não autorizada.');
            }

            $faturaModel->update($faturaId, ['status' => 'Paga']);

            return $this->response->setJSON(['success' => true]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
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
     * Processa a alteração de senha feita pelo cliente no seu perfil.
     */
    public function salvarSenha()
    {
        // 1. Validação dos campos
        $validation = $this->validate([
            'senha_atual'       => 'required',
            'nova_senha'        => 'required|min_length[6]',
            'confirmar_senha'   => 'required|matches[nova_senha]'
        ]);

        if (!$validation) {
            return redirect()->to('cliente/perfil')->with('errors', $this->validator->getErrors());
        }

        $repo = new UserRepository();
        $usuarioLogado = session()->get('usuario');

        // 2. Verifica se a senha atual está correta
        $usuarioNoBanco = $repo->find($usuarioLogado['id']);
        $senhaAtual = $this->request->getPost('senha_atual');

        if (!password_verify($senhaAtual, $usuarioNoBanco['senha'])) {
            return redirect()->to('cliente/perfil')->with('error', 'A sua senha atual está incorreta.');
        }

        // 3. Se estiver tudo certo, atualiza para a nova senha
        $novaSenhaHash = password_hash($this->request->getPost('nova_senha'), PASSWORD_DEFAULT);
        
        if ($repo->update($usuarioLogado['id'], ['senha' => $novaSenhaHash])) {
            return redirect()->to('cliente/perfil')->with('success', 'Senha alterada com sucesso!');
        } else {
            return redirect()->to('cliente/perfil')->with('error', 'Ocorreu um erro ao atualizar a sua senha. Tente novamente.');
        }
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

    public function pagar($id)
    {
        $faturaModel = new FaturaModel();

        // Obter o ID do cliente logado a partir da sessão
        $clienteId = session()->get('usuario_id');

        // Busca a fatura e verifica se ela pertence ao cliente logado
        $fatura = $faturaModel->where('id', $id)->where('cliente_id', $clienteId)->first();

        if (!$fatura) {
            // Se a fatura não for encontrada ou não pertencer ao cliente,
            // redireciona com uma mensagem de erro.
            return redirect()->to('cliente/faturas')->with('error', 'Fatura inválida ou não autorizada.');
        }

        // Lógica para integrar com o gateway de pagamento (Stripe, PagSeguro, etc.)
        //
        // Por agora, vamos simular que o pagamento foi bem-sucedido e atualizar o status.
        // Isso deve ser feito APÓS a confirmação do gateway em um cenário real.
        $data = [
            'status' => 'Paga'
        ];

        if ($faturaModel->update($id, $data)) {
            // Redireciona de volta para a lista de faturas com uma mensagem de sucesso
            return redirect()->to('cliente/faturas')->with('success', 'Pagamento da fatura #' . $id . ' processado com sucesso!');
        } else {
            // Se a atualização falhar, redireciona com uma mensagem de erro
            return redirect()->to('cliente/faturas/visualizar/' . $id)->with('error', 'Ocorreu um erro ao atualizar o status da fatura.');
        }
    }
}
