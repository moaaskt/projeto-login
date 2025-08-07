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
        $repo = new \App\Repositories\UserRepository();

        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('password');

        $usuario = $repo->getUsuarioPorEmail($email);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            unset($usuario['senha']);

            $sessionData = [
                'usuario'   => $usuario,
                'logged_in' => true,
            ];
            $session->set($sessionData);

            // --- LÓGICA DE REDIRECIONAMENTO INTELIGENTE ---
            if ($usuario['role'] === 'admin') {
                return redirect()->to(base_url('/dashboard')); // Admin vai para o painel CRM
            } else {
                return redirect()->to(base_url('/portal')); // Cliente vai para seu portal
            }
            
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
