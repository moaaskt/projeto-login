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
        // 1. Define as regras de validação
        $regras = [
            'nome'  => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'senha' => 'required|min_length[8]',
            'confirmar_senha' => 'required|matches[senha]'
        ];

        // 2. Executa a validação
        if (!$this->validate($regras)) {
            // Se a validação falhar, retorna para o formulário com os erros
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 3. Se a validação passar, continua para salvar
        $usuarioModel = new \App\Models\UsuarioModel();
        $dados = $this->request->getPost();

        $dadosParaSalvar = [
            'nome'   => $dados['nome'],
            'email'  => $dados['email'],
            'senha'  => password_hash($dados['senha'], PASSWORD_DEFAULT),
        ];

        if ($usuarioModel->insert($dadosParaSalvar)) {
            return redirect()->to(base_url('/'))->with('success', 'Cadastro realizado com sucesso! Faça seu login.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Ocorreu uma falha ao realizar o cadastro.');
        }
    }
}