<?php

namespace App\Controllers\auth\login;

use App\Controllers\BaseController;
use App\Libraries\EmailSes;
use App\Repositories\UserRepository;

class Login extends BaseController
{
    /**
     * Exibe a página de login.
     */
    public function index()
    {
        return view('auth/login/index');
    }

    /**
     * Autentica o usuário e redireciona com base na sua role.
     */
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

            if ($usuario['role'] === 'admin') {
                return redirect()->to(base_url('dashboard'));
            } else {
                return redirect()->to(base_url('cliente/dashboard'));
            }
        } else {
            $session->setFlashdata('msg', 'E-mail ou senha inválidos.');
            return redirect()->to(base_url('/'));
        }
    }

    // ====================================================================
    // == MÉTODOS DE REDEFINIÇÃO DE SENHA ==
    // ====================================================================

    /**
     * Exibe o formulário para solicitar a redefinição de senha.
     */
    public function forgotPassword()
    {
        return view('auth/forgotpass/forgot_password', ['title' => 'Recuperar Senha']);
    }

    /**
     * Valida o e-mail, gera um token e envia o link de redefinição.
     */
    public function sendResetLink()
    {
        $validation = $this->validate(['email' => 'required|valid_email']);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $repo = new UserRepository();
        $usuario = $repo->getUsuarioPorEmail($email);

        if ($usuario) {
            try {
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', time() + 3600); // Expira em 1 hora

                $repo->update($usuario['id'], [
                    'reset_token'   => $token,
                    'reset_expires' => $expires,
                ]);

                $emailLib = new EmailSes();
                $resetLink = site_url('reset-password/' . $token);
                
                $subject = "Redefinição de Senha - Seu CRM";
                $message = "<h1>Redefinição de Senha</h1>
                            <p>Você solicitou a redefinição da sua senha. Clique no link abaixo para criar uma nova senha:</p>
                            <p><a href='{$resetLink}'>Redefinir Minha Senha</a></p>
                            <p>Se você não solicitou isso, ignore este e-mail. O link é válido por 1 hora.</p>";
                
                $email_from = 'nao-responda@seusistema.com';
                $name_from = 'Suporte do Sistema CRM';

                $emailLib->enviarEmail($email, $email_from, $name_from, $subject, $message);

            } catch (\Exception $e) {
                log_message('error', '[sendResetLink] ' . $e->getMessage());
                $errorMessage = 'Ocorreu um erro inesperado. Tente novamente.';
                if (ENVIRONMENT === 'development') {
                    $errorMessage .= '<br><small>Debug: ' . esc($e->getMessage()) . '</small>';
                }
                session()->setFlashdata('msg_error', $errorMessage);
                return redirect()->to('forgot-password');
            }
        }

        session()->setFlashdata('msg_success', 'Se um e-mail correspondente for encontrado, um link de redefinição será enviado.');
        return redirect()->to('forgot-password');
    }

    /**
     * Exibe o formulário para o usuário criar a nova senha.
     * @param string $token O token recebido por e-mail.
     */
    public function resetPassword($token)
    {
        $repo = new UserRepository();
        
        $usuario = $repo->where('reset_token', $token)
                        ->where('reset_expires >', date('Y-m-d H:i:s'))
                        ->first();

        if (!$usuario) {
            session()->setFlashdata('msg_error', 'O link de redefinição é inválido ou expirou.');
            return redirect()->to('forgot-password');
        }

        return view('auth/forgotpass/reset_password', [
            'title' => 'Redefinir Senha',
            'token' => $token
        ]);
    }

    /**
     * Valida e atualiza a nova senha do usuário no banco de dados.
     */
    public function updatePassword()
    {
        $validation = $this->validate([
            'token'             => 'required',
            'password'          => 'required|min_length[6]',
            'password_confirm'  => 'required|matches[password]'
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $token = $this->request->getPost('token');
        $senha = $this->request->getPost('password');

        $repo = new UserRepository();
        
        $usuario = $repo->where('reset_token', $token)
                        ->where('reset_expires >', date('Y-m-d H:i:s'))
                        ->first();

        if (!$usuario) {
            session()->setFlashdata('msg_error', 'O link de redefinição é inválido ou expirou.');
            return redirect()->to('forgot-password');
        }

        $repo->update($usuario['id'], [
            'senha'         => password_hash($senha, PASSWORD_DEFAULT),
            'reset_token'   => null,
            'reset_expires' => null
        ]);

        session()->setFlashdata('msg_success', 'Sua senha foi redefinida com sucesso! Você já pode fazer login.');
        return redirect()->to('/');
    }

    /**
     * Faz o logout do usuário.
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
