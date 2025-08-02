<?php

namespace App\Controllers\auth\cadastro;

use App\Controllers\BaseController;
use App\Models\UsuarioModel; // <-- 1. CORREÇÃO AQUI

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
        // Pega os dados do formulário
        $dados = $this->request->getPost();

        // Validação simples
        if ($dados['senha'] !== $dados['confirmar_senha']) {
            return redirect()->back()->withInput()->with('error', 'As senhas não conferem. Tente novamente.');
        }

        // Prepara os dados para salvar
        $usuarioModel = new UsuarioModel(); // <-- 2. CORREÇÃO AQUI

        // Criptografa a senha antes de salvar!
        $dadosParaSalvar = [
            'nome'   => $dados['nome'],
            'email'  => $dados['email'],
            'senha'  => password_hash($dados['senha'], PASSWORD_DEFAULT),
        ];

        // Tenta inserir no banco de dados
        if ($usuarioModel->insert($dadosParaSalvar)) {
            return redirect()->to(base_url('/'))->with('success', 'Cadastro realizado com sucesso! Faça seu login.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Ocorreu uma falha ao realizar o cadastro. Tente novamente.');
        }
    }
}