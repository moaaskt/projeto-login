<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;
use App\Models\FaturaModel; // Supondo que você tenha um FaturaModel

class FaturasController extends BaseController
{
    /**
     * Lista apenas as faturas do cliente logado.
     */
    public function index()
    {
        $faturaModel = new FaturaModel();

        // Pega o ID do cliente da sessão.
        $clienteId = session()->get('usuario')['cliente_id'];



        $data = [
            'title'   => 'Minhas Faturas',
            'faturas' => $faturaModel->where('cliente_id', $clienteId)
                ->orderBy('data_vencimento', 'DESC')
                ->findAll(),
        ];

        return view('portal/faturas/index', $data);
    }

    /**
     * Mostra os detalhes de UMA fatura, mas antes verifica se ela
     * pertence mesmo ao cliente logado. Medida de segurança!
     */
    public function visualizar($id)
    {
        $faturaModel = new FaturaModel();
        $clienteId = session()->get('usuario')['cliente_id'];

        // Busca a fatura
        $fatura = $faturaModel->find($id);

        // VERIFICAÇÃO DE SEGURANÇA CRUCIAL:
        // Se a fatura não existe OU se o cliente_id da fatura é diferente do cliente logado, nega o acesso.
        if ($fatura === null || $fatura['cliente_id'] != $clienteId) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'  => 'Detalhes da Fatura',
            'fatura' => $fatura,
        ];

        return view('portal/faturas/visualizar', $data);
    }

    /**
     * Placeholder para a função de pagamento.
     */
    public function pagar($id)
    {
        // A mesma verificação de segurança é necessária aqui
        $faturaModel = new FaturaModel();
        $clienteId = session()->get('usuario')['cliente_id'];
        $fatura = $faturaModel->find($id);

        if ($fatura === null || $fatura['cliente_id'] != $clienteId) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // AQUI ENTRARIA A LÓGICA DE INTEGRAÇÃO COM MERCADO PAGO, PAGSEGURO, ETC.
        // Por enquanto, vamos apenas mostrar uma mensagem.
        return "<h1>Página de Pagamento para a Fatura #{$id}</h1><p>Status: {$fatura['status']}</p><p>Em construção...</p>";
    }
}
