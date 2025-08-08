<?php

namespace App\Controllers;

use App\Models\FaturaModel;
use App\Models\UsuarioModel;

class ClienteController extends BaseController
{
    // ... seus outros métodos (faturas, perfil, etc.) ...

    /**
     * Processa o pagamento de uma fatura específica.
     *
     * @param int $id O ID da fatura a ser paga.
     */
    public function pagar($id)
    {
        // 1. Verificar se o cliente está logado e se a fatura pertence a ele
        // (Adicionar lógica de verificação de segurança aqui é crucial)

        $faturaModel = new FaturaModel();
        $fatura = $faturaModel->find($id);

        // Verifica se a fatura existe e se pertence ao cliente logado
        // A sessão 'usuario_id' deve ser o ID do cliente logado
        if (!$fatura || $fatura['cliente_id'] != session()->get('usuario_id')) {
            // Se a fatura não for encontrada ou não pertencer ao cliente,
            // redireciona com uma mensagem de erro.
            return redirect()->to('/cliente/faturas')->with('error', 'Fatura inválida ou não encontrada.');
        }

        // 2. Lógica para integrar com o gateway de pagamento
        // Aqui você adicionaria o código para iniciar a sessão de pagamento
        // com PagSeguro, Mercado Pago, Stripe, etc.
        // Por enquanto, vamos simular uma atualização de status.

        // Exemplo: Simplesmente marcar a fatura como "Paga"
        // Em um cenário real, isso seria feito após a confirmação do gateway.
        $data = [
            'status' => 'Paga'
        ];

        if ($faturaModel->update($id, $data)) {
            // Redireciona de volta para a lista de faturas com uma mensagem de sucesso
            return redirect()->to('/cliente/faturas')->with('success', 'Fatura #' . $id . ' marcada como paga com sucesso!');
        } else {
            // Se a atualização falhar, redireciona com uma mensagem de erro
            return redirect()->to('/cliente/faturas/detalhes/' . $id)->with('error', 'Ocorreu um erro ao processar o pagamento.');
        }
    }

    // ... resto do seu controlador ...
}