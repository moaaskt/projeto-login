<?php

// O namespace continua exatamente o mesmo
namespace App\Controllers\auth\login;

use App\Controllers\BaseController;


class Login extends BaseController
{
    // O método index() continua igual.
    public function index()
    {
        return view('auth/login/index');
    }

    // A mágica acontece aqui no método auth()
   /**
     * Autentica o usuário e redireciona com base na sua role.
     */
    public function auth()
    {
        $session = session();
        $repo = new \App\Repositories\UserRepository(); // Assumindo que seu repositório está correto

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

            // --- LÓGICA DE REDIRECIONAMENTO CORRIGIDA ---

            // CORREÇÃO 1: Verificando a role diretamente da variável $usuario
            if ($usuario['role'] === 'admin') {
                return redirect()->to(base_url('dashboard'));
            } else {
                // CORREÇÃO 2: Apontando para a nova rota correta do cliente
                return redirect()->to(base_url('cliente/dashboard'));
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
