<?php

namespace App\Controllers\auth\login;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Login extends BaseController
{
    public function index()
    {
        return view('auth/login/index');
    }

    public function auth()
    {
        $session = session();
        $model = new UsuarioModel();

        // Pega os dados do formulário
        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('password');

        // Busca o usuário no banco de dados pelo e-mail
        $usuario = $model->where('email', $email)->first();

        // Verifica se encontrou um usuário E se a senha está correta
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Se a verificação for bem-sucedida...

            // Remove a senha do array antes de salvar na sessão por segurança
            unset($usuario['senha']);

            // Define os dados da sessão
            $sessionData = [
                'usuario'   => $usuario,
                'logged_in' => true,
            ];
            $session->set($sessionData);

            // Redireciona para o dashboard
            return redirect()->to(base_url('/dashboard'));
        } else {
            // Se o usuário não existe ou a senha está errada...
            $session->setFlashdata('msg', 'E-mail ou senha inválidos.');
            return redirect()->to(base_url('/'));
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}