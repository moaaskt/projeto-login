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

    /**
     * Gera um PDF da fatura para download
     * 
     * @param int $faturaId ID da fatura
     * @return mixed
     */
    public function gerarPDF($faturaId)
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

        // 5. Preparar o HTML para o PDF
        $html = '<html><head>';
        $html .= '<style>
            body { font-family: Arial, sans-serif; margin: 30px; }
            .header { text-align: center; margin-bottom: 30px; }
            .fatura-info { border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; }
            .fatura-titulo { font-size: 24px; margin-bottom: 20px; }
            .fatura-detalhe { margin-bottom: 10px; }
            .fatura-valor { font-size: 18px; font-weight: bold; }
            .fatura-status { display: inline-block; padding: 5px 10px; border-radius: 3px; }
            .status-pendente { background-color: #ffc107; color: #000; }
            .status-paga { background-color: #28a745; color: #fff; }
            .status-vencida { background-color: #dc3545; color: #fff; }
            .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #666; }
        </style>';
        $html .= '</head><body>';
        
        // Cabeçalho
        $html .= '<div class="header"><h1>Fatura #' . $fatura['id'] . '</h1></div>';
        
        // Informações da fatura
        $html .= '<div class="fatura-info">';
        $html .= '<div class="fatura-titulo">' . $fatura['descricao'] . '</div>';
        
        // Status com classe CSS apropriada
        $statusClass = 'status-pendente';
        if (strtolower($fatura['status']) === 'paga') {
            $statusClass = 'status-paga';
        } elseif (strtolower($fatura['status']) === 'vencida') {
            $statusClass = 'status-vencida';
        }
        
        $html .= '<div class="fatura-detalhe">Status: <span class="fatura-status ' . $statusClass . '">' . ucfirst($fatura['status']) . '</span></div>';
        $html .= '<div class="fatura-detalhe fatura-valor">Valor: R$ ' . number_format($fatura['valor'], 2, ',', '.') . '</div>';
        $html .= '<div class="fatura-detalhe">Data de Emissão: ' . date('d/m/Y', strtotime($fatura['created_at'])) . '</div>';
        $html .= '<div class="fatura-detalhe">Data de Vencimento: ' . date('d/m/Y', strtotime($fatura['data_vencimento'])) . '</div>';
        $html .= '</div>';
        
        // Rodapé
        $html .= '<div class="footer">Este documento é uma representação digital da sua fatura. Gerado em ' . date('d/m/Y H:i:s') . '</div>';
        
        $html .= '</body></html>';

        // 6. Configurar e gerar o PDF
        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // 7. Fazer o download do PDF
        return $dompdf->stream("fatura_{$fatura['id']}.pdf", ["Attachment" => true]);
    }

    /**
     * Gera um PDF do boleto para download
     * 
     * @param int $faturaId ID da fatura
     * @return mixed
     */
    public function gerarBoleto($faturaId)
    {
        // 1. Instanciar o Model de Faturas
        $faturaModel = new \App\Models\FaturaModel();

        // 2. Pegar o ID do cliente logado na sessão (para segurança)
        $clienteId = session()->get('usuario')['id'];

        // 3. Buscar a fatura no banco de dados com uma condição dupla
        $fatura = $faturaModel->where('id', $faturaId)
            ->where('cliente_id', $clienteId)
            ->first();

        // 4. Se a fatura não for encontrada (ou não pertencer ao cliente), mostra erro 404.
        if (!$fatura) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Fatura não encontrada ou não pertence a você.');
        }

        // 5. Preparar o HTML para o PDF do boleto
        $html = '<html><head>';
        $html .= '<style>
            body { font-family: Arial, sans-serif; margin: 30px; }
            .header { text-align: center; margin-bottom: 30px; }
            .boleto-container { border: 1px solid #000; padding: 20px; margin-bottom: 30px; }
            .boleto-header { border-bottom: 1px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
            .boleto-info { margin-bottom: 20px; }
            .boleto-info-row { display: flex; margin-bottom: 10px; }
            .boleto-info-label { width: 200px; font-weight: bold; }
            .boleto-info-value { flex: 1; }
            .boleto-barcode { text-align: center; margin: 30px 0; }
            .boleto-barcode img { max-width: 100%; height: 80px; }
            .boleto-valor { font-size: 18px; font-weight: bold; }
            .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #666; }
            .instrucoes { margin-top: 20px; border-top: 1px dashed #000; padding-top: 20px; }
            .instrucoes h3 { margin-bottom: 10px; }
            .instrucoes ul { padding-left: 20px; }
        </style>';
        $html .= '</head><body>';
        
        // Cabeçalho
        $html .= '<div class="header"><h1>Boleto de Pagamento</h1></div>';
        
        // Container do boleto
        $html .= '<div class="boleto-container">';
        $html .= '<div class="boleto-header"><h2>Dados do Boleto</h2></div>';
        
        // Informações do boleto
        $html .= '<div class="boleto-info">';
        $html .= '<div class="boleto-info-row"><div class="boleto-info-label">Beneficiário:</div><div class="boleto-info-value">Sistema de Faturas</div></div>';
        $html .= '<div class="boleto-info-row"><div class="boleto-info-label">CNPJ:</div><div class="boleto-info-value">00.000.000/0001-00</div></div>';
        $html .= '<div class="boleto-info-row"><div class="boleto-info-label">Descrição:</div><div class="boleto-info-value">' . $fatura['descricao'] . '</div></div>';
        $html .= '<div class="boleto-info-row"><div class="boleto-info-label">Número da Fatura:</div><div class="boleto-info-value">' . $fatura['id'] . '</div></div>';
        $html .= '<div class="boleto-info-row"><div class="boleto-info-label">Data de Emissão:</div><div class="boleto-info-value">' . date('d/m/Y', strtotime($fatura['created_at'])) . '</div></div>';
        $html .= '<div class="boleto-info-row"><div class="boleto-info-label">Data de Vencimento:</div><div class="boleto-info-value">' . date('d/m/Y', strtotime($fatura['data_vencimento'])) . '</div></div>';
        $html .= '<div class="boleto-info-row"><div class="boleto-info-label">Valor:</div><div class="boleto-info-value boleto-valor">R$ ' . number_format($fatura['valor'], 2, ',', '.') . '</div></div>';
        $html .= '</div>';
        
        // Código de barras (simulado)
        $html .= '<div class="boleto-barcode">';
        $html .= '<img src="https://www.bcb.gov.br/content/estabilidadefinanceira/pix/Marca_Pix/Marca_Pix_2.jpg" alt="Código de Barras">';
        $html .= '</div>';
        
        // Instruções
        $html .= '<div class="instrucoes">';
        $html .= '<h3>Instruções</h3>';
        $html .= '<ul>';
        $html .= '<li>Este é um boleto simulado para fins de demonstração.</li>';
        $html .= '<li>Em um ambiente real, este boleto teria um código de barras válido para pagamento.</li>';
        $html .= '<li>Não efetue pagamento com este boleto.</li>';
        $html .= '</ul>';
        $html .= '</div>';
        
        $html .= '</div>'; // Fim do container do boleto
        
        // Rodapé
        $html .= '<div class="footer">Este documento é uma representação digital do seu boleto. Gerado em ' . date('d/m/Y H:i:s') . '</div>';
        
        $html .= '</body></html>';

        // 6. Configurar e gerar o PDF
        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // 7. Fazer o download do PDF
        return $dompdf->stream("boleto_fatura_{$fatura['id']}.pdf", ["Attachment" => true]);
    }
}
