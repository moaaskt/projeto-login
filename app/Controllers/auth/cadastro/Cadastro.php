<?php

namespace App\Controllers\auth\cadastro;

use App\Controllers\BaseController;
use App\Repositories\UserRepository;
use App\Repositories\ClienteRepository;

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
     * Processa o formulário de cadastro.
     */


    public function store()
    {
      
        $regras = [
            'nome'            => 'required|min_length[3]',
            'email'           => 'required|valid_email|is_unique[usuarios.email]',
            'senha'           => 'required|min_length[8]',
            'confirmar_senha' => 'required|matches[senha]'
        ];

        if (!$this->validate($regras)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

   
        $clienteRepo = new ClienteRepository();
        $userRepo = new UserRepository();
     
        $dadosCliente = [
            'nome_completo' => $this->request->getPost('nome'),
            'email'         => $this->request->getPost('email'),
        ];

     
        $clienteRepo->insert($dadosCliente);
     
        $novoClienteId = $clienteRepo->getLastInsertID();


      
        if (!$novoClienteId) {
            return redirect()->back()->withInput()->with('error', 'Ocorreu uma falha crítica ao criar o cliente.');
        }

        $dadosUsuario = [
            'nome'       => $this->request->getPost('nome'),
            'email'      => $this->request->getPost('email'),
            'senha'      => $this->request->getPost('senha'),
            'cliente_id' => $novoClienteId, 
        ];

        
        if ($userRepo->criarUsuario($dadosUsuario)) {
            return redirect()->to(base_url('/'))->with('success', 'Cadastro realizado com sucesso! Faça seu login.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Ocorreu uma falha ao criar o usuário.');
        }
    }
}
