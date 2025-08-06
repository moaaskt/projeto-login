<?php

namespace App\Controllers\auth\cadastro;

use App\Controllers\BaseController;
// 1. TROCAMOS o 'use' do Model pelo 'use' do nosso UserRepository.
use App\Repositories\UserRepository;

class Cadastro extends BaseController
{
    /**
     * Exibe a página com o formulário de cadastro.
     * (Este método não muda)
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
        // 1. Validação (continua sendo responsabilidade do Controller)
        $regras = [
            'nome'            => 'required|min_length[3]',
            'email'           => 'required|valid_email|is_unique[usuarios.email]',
            'senha'           => 'required|min_length[8]',
            'confirmar_senha' => 'required|matches[senha]'
        ];

        if (!$this->validate($regras)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Cria uma instância do Repositório
        $repo = new UserRepository();
        $dados = $this->request->getPost();

        // 3. Chama o método do repositório
        // O controller não precisa mais saber como a senha é tratada.
        if ($repo->criarUsuario($dados)) {
            return redirect()->to(base_url('/'))->with('success', 'Cadastro realizado com sucesso! Faça seu login.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Ocorreu uma falha ao realizar o cadastro.');
        }
    }
}
