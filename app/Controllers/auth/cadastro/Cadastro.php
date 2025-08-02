<?php

namespace App\Controllers\auth\cadastro;

use App\Controllers\BaseController;
use App\Models\Usuario; // Importa o seu Model de Usuário

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
        // 1. Pega os dados do formulário
        $dados = $this->request->getPost();

        // 2. Validação simples (pode ser melhorada depois)
        if ($dados['senha'] !== $dados['confirmar_senha']) {
            // Se as senhas não conferem, volta para o formulário com uma mensagem de erro
            return redirect()->back()->withInput()->with('error', 'As senhas não conferem. Tente novamente.');
        }

        // 3. Prepara os dados para salvar
        $usuarioModel = new Usuario();

        // IMPORTANTE: Criptografa a senha antes de salvar!
        $dadosParaSalvar = [
            'nome'   => $dados['nome'],
            'email'  => $dados['email'],
            'senha'  => password_hash($dados['senha'], PASSWORD_DEFAULT),
        ];

        // 4. Tenta inserir no banco de dados
        if ($usuarioModel->insert($dadosParaSalvar)) {
            // Se deu certo, redireciona para a página de login com uma mensagem de sucesso
            return redirect()->to(base_url('/'))->with('success', 'Cadastro realizado com sucesso! Faça seu login.');
        } else {
            // Se deu errado, volta para o formulário com uma mensagem de erro
            return redirect()->back()->withInput()->with('error', 'Ocorreu uma falha ao realizar o cadastro. Tente novamente.');
        }
    }
}