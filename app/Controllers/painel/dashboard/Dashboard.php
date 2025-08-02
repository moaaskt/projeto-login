<?php

namespace App\Controllers\painel\dashboard;

use App\Controllers\BaseController;
use App\Models\ClienteModel; // <-- 1. IMPORTAMOS O MODEL DE CLIENTE

class Dashboard extends BaseController
{
    // ... (métodos index, perfil, faturas continuam iguais) ...
    public function index()
    {
        $session = session();
        $data['email'] = $session->get('usuario')['email'];
        $data['title'] = 'Dashboard Principal';
        return view('painel/dashboard/index', $data);
    }

    // --- MÉTODOS DE CLIENTES ---

    /**
     * Lista todos os clientes
     */
    public function clientes()
    {
        $clienteModel = new ClienteModel();
        $data = [
            'clientes' => $clienteModel->findAll(), // Busca todos os clientes
            'title'    => 'Meus Clientes'
        ];
        return view('painel/clientes/index', $data);
    }

    /**
     * Mostra o formulário para criar um novo cliente
     */
    public function novoCliente()
    {
        $data = [
            'title' => 'Novo Cliente'
        ];
        return view('painel/clientes/form', $data);
    }

    /**
     * Mostra o formulário para editar um cliente existente
     */
    public function editarCliente($id)
    {
        $clienteModel = new ClienteModel();
        $data = [
            'cliente' => $clienteModel->find($id), // Busca o cliente específico pelo ID
            'title'   => 'Editar Cliente'
        ];
        return view('painel/clientes/form', $data);
    }

    /**
     * Salva um novo cliente ou atualiza um existente
     */
    public function salvarCliente()
    {
        $clienteModel = new ClienteModel();
        $dados = $this->request->getPost();

        if ($clienteModel->save($dados)) {
            return redirect()->to(base_url('dashboard/clientes'))->with('success', 'Cliente salvo com sucesso!');
        } else {
            return redirect()->back()->withInput()->with('errors', $clienteModel->errors());
        }
    }

    /**
     * Exclui um cliente (soft delete)
     */
    public function excluirCliente($id)
    {
        $clienteModel = new ClienteModel();
        if ($clienteModel->delete($id)) {
            return redirect()->to(base_url('dashboard/clientes'))->with('success', 'Cliente excluído com sucesso!');
        } else {
            return redirect()->to(base_url('dashboard/clientes'))->with('error', 'Ocorreu um erro ao excluir o cliente.');
        }
    }
    
    // --- FIM DOS MÉTODOS DE CLIENTES ---

    public function perfil()
    {
        $data['title'] = 'Meu Perfil';
        return view('painel/perfil/index', $data);
    }

    public function faturas()
    {
        $data['title'] = 'Minhas Faturas';
        return view('painel/faturas/index', $data);
    }
}