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
        // 2. TROCAMOS a criação do Model pela criação do Repository.
        $repo = new UserRepository();

        // A captura dos dados do formulário continua igual.
        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('password');

        // 3. AQUI ESTÁ A GRANDE MUDANÇA:
        // Em vez de $model->where(...), usamos nosso método limpo do repositório.
        // A responsabilidade de saber COMO buscar no banco foi para o Repository.
        $usuario = $repo->getUsuarioPorEmail($email);

        // O resto do seu código, com toda a lógica de verificação de senha,
        // criação de sessão e redirecionamentos, continua EXATAMENTE IGUAL,
        // pois ele não se importa de onde a variável $usuario veio.
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

    // O método logout() continua igual.
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
