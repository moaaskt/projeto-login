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
        // A sua lógica de validação continua EXATAMENTE a mesma.
        // Ela é perfeita e não precisa ser alterada.
        $regras = [
            'nome'  => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'senha' => 'required|min_length[8]',
            'confirmar_senha' => 'required|matches[senha]'
        ];

        if (!$this->validate($regras)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Se a validação passar, a mágica acontece aqui.
        // Criamos uma instância do nosso repositório.
        $repo = new UserRepository();

        // Pegamos todos os dados do formulário de uma vez.
        $dados = $this->request->getPost();

        // 3. AQUI ESTÁ A GRANDE MUDANÇA:
        // Chamamos nosso método 'criarUsuario'.
        // Não precisamos mais nos preocupar em hashear a senha aqui.
        // O repositório cuida disso para nós! O controller fica mais limpo.
        if ($repo->criarUsuario($dados)) {
            // A sua lógica de redirecionamento de sucesso continua a mesma.
            return redirect()->to(base_url('/'))->with('success', 'Cadastro realizado com sucesso! Faça seu login.');
        } else {
            // A sua lógica de redirecionamento de falha continua a mesma.
            return redirect()->back()->withInput()->with('error', 'Ocorreu uma falha ao realizar o cadastro.');
        }
    }
}
