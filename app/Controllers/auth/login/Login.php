<?php

// O namespace continua exatamente o mesmo
namespace App\Controllers\auth\login;

use App\Controllers\BaseController;
// 1. TROCAMOS o 'use' do Model pelo 'use' do Repository.
// O Controller não precisa mais saber do Model, apenas do Repository.
use App\Repositories\UserRepository;

class Login extends BaseController
{
    // O método index() continua igual.
    public function index()
    {
        return view('auth/login/index');
    }

    // A mágica acontece aqui no método auth()
      public function auth()
    {
        $session = session();
        
        // 1. Cria uma instância do Repositório
        $repo = new UserRepository();

        // 2. Pega os dados do formulário
        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('password');

        // 3. Usa o método do repositório para buscar o usuário
        $usuario = $repo->getUsuarioPorEmail($email);

        // 4. A lógica de verificação de senha e sessão continua a mesma
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            unset($usuario['senha']); // Remove a senha por segurança

            $sessionData = [
                'usuario'   => $usuario,
                'logged_in' => true,
            ];
            $session->set($sessionData);

            return redirect()->to(base_url('/dashboard'));
        } else {
            $session->setFlashdata('msg', 'E-mail ou senha inválidos.');
            return redirect()->to(base_url('/'));
        }
    }

    // O método logout() continua igual.
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
