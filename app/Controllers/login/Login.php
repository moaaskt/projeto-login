<?php

namespace App\Controllers\login;

use App\Controllers\BaseController;

class Login extends BaseController
{
    public function index()
    {
        return view('auth/login/index');
    }

    public function auth()
    {
        $session = session();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if ($email === 'chefe@empresa.com' && $password === 'senhaforte') {
            $sessionData = [
                'email'     => $email,
                'logged_in' => true,
            ];
            $session->set($sessionData);
            return redirect()->to(base_url('/dashboard'));
        } else {
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