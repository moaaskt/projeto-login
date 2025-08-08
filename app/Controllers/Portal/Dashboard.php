<?php

namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\FaturaModel; // Certifique-se de que o FaturaModel está sendo importado

class Dashboard extends BaseController
{
    /**
     * Exibe o painel principal do cliente com suas faturas.
     */
    public function index()
    {
        // 1. Iniciar o serviço de sessão
        $session = session();

        // 2. Obter o ID do usuário logado a partir da sessão
        //    Estou assumindo que a chave na sessão é 'id' após o login.
        $clienteId = $session->get('id');

        // Validação: Se por algum motivo não houver ID na sessão, redireciona para o login
        if (!$clienteId) {
            return redirect()->to('/login')->with('error', 'Sessão inválida. Por favor, faça login novamente.');
        }

        // 3. Instanciar o Model de Faturas
        $faturaModel = new FaturaModel();

        // 4. Buscar as faturas aplicando o filtro com base no ID do cliente
        //    A função where() filtra os resultados pela coluna 'cliente_id'
        $faturas = $faturaModel->where('cliente_id', $clienteId)
                               ->orderBy('data_vencimento', 'DESC') // Opcional: ordenar faturas da mais recente para a mais antiga
                               ->findAll();

        // 5. Montar o array de dados para enviar à View
        $data = [
            'titulo' => 'Meu Painel de Faturas',
            'faturas' => $faturas,
            'nome_usuario' => $session->get('nome') // Opcional: para exibir uma mensagem de boas-vindas
        ];

        // 6. Carregar a view do dashboard do cliente, passando os dados filtrados
        return view('cliente/dashboard', $data);
    }
}