<?php

namespace App\Controllers\auth\cadastro;

use App\Controllers\BaseController;
// --- ALTERAÇÃO 1: INCLUSÃO DOS DOIS REPOSITÓRIOS ---
// O controller agora precisa conhecer ambos para orquestrar a operação.
use App\Repositories\UserRepository;
use App\Repositories\ClienteRepository;

class Cadastro extends BaseController
{
    /**
     * Exibe a página com o formulário de cadastro.
     */
    public function index()
    {
        return view('auth/cadastro/index');
    }

    /**
     * Recebe os dados do formulário, valida e salva no banco de dados.
     */
    public function store()
    {
        // A validação continua a mesma.
        $regras = [
            'nome'            => 'required|min_length[3]',
            'email'           => 'required|valid_email|is_unique[usuarios.email]',
            'senha'           => 'required|min_length[8]',
            'confirmar_senha' => 'required|matches[senha]'
        ];

        if (!$this->validate($regras)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // --- LÓGICA DE ORQUESTRAÇÃO ---

        // 1. Cria uma instância dos dois repositórios.
        $clienteRepo = new ClienteRepository();
        $userRepo = new UserRepository();
        
        // 2. Prepara os dados para a tabela 'clientes'.
        //    Para um cadastro simples, usamos o 'nome' do formulário.
        $dadosCliente = [
            'nome_completo' => $this->request->getPost('nome'),
            'email'         => $this->request->getPost('email'),
        ];

        // 3. Salva o cliente PRIMEIRO.
        $clienteRepo->insert($dadosCliente);
        
        // 4. Pega o ID do cliente que acabou de ser inserido.
        $novoClienteId = $clienteRepo->getLastInsertID();


        //  dd('ID do novo cliente obtido:', $novoClienteId);
        
        // Se, por algum motivo, não conseguir o ID, retorna um erro.
        if (!$novoClienteId) {
            return redirect()->back()->withInput()->with('error', 'Ocorreu uma falha crítica ao criar o cliente.');
        }

        // 5. Prepara os dados para a tabela 'usuarios', agora incluindo a "ponte".
        $dadosUsuario = [
            'nome'       => $this->request->getPost('nome'),
            'email'      => $this->request->getPost('email'),
            'senha'      => $this->request->getPost('senha'),
            'cliente_id' => $novoClienteId, // A ASSOCIAÇÃO ACONTECE AQUI!
        ];

        // 6. Chama o método do repositório de usuário, passando todos os dados.
        if ($userRepo->criarUsuario($dadosUsuario)) {
            return redirect()->to(base_url('/'))->with('success', 'Cadastro realizado com sucesso! Faça seu login.');
        } else {
            // Em um cenário real, aqui deveria haver uma lógica para deletar o cliente que foi criado
            // mas não teve um usuário associado (transação). Por agora, isso resolve o fluxo.
            return redirect()->back()->withInput()->with('error', 'Ocorreu uma falha ao criar o usuário.');
        }
    }
}
