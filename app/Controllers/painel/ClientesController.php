<?php

namespace App\Controllers\painel;

use App\Controllers\BaseController;
use App\Models\ClienteModel;

class ClientesController extends BaseController
{
    /**
     * Exibe a lista de clientes.
     */
    public function index()
    {
        $clienteModel = new ClienteModel();

        // Pega os filtros da URL (via GET)
        $filters = [
            'termo'         => $this->request->getGet('termo'),
            'data_cadastro' => $this->request->getGet('data_cadastro')
        ];

        $data = [
            // Passa os filtros para o Model fazer a busca
            'clientes' => $clienteModel->search($filters),
            'title'    => 'Meus Clientes',
            'filters'  => $filters // Devolve os filtros para a View
        ];

        return view('painel/clientes/index', $data);
    }

    /**
     * Mostra o formulário para um novo cliente.
     */
    public function novo()
    {
        $data = ['title' => 'Novo Cliente'];
        return view('painel/clientes/form', $data);
    }

    /**
     * Mostra o formulário para editar um cliente.
     */
    public function editar($id)
    {
        $clienteModel = new ClienteModel();
        $data = [
            'cliente' => $clienteModel->find($id),
            'title'   => 'Editar Cliente'
        ];
        return view('painel/clientes/form', $data);
    }

    /**
     * Processa o salvamento de um cliente.
     */
    public function salvar()
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
     * Exclui um cliente.
     */
    public function excluir($id)
    {
        $clienteModel = new ClienteModel();
        if ($clienteModel->delete($id)) {
            return redirect()->to(base_url('dashboard/clientes'))->with('success', 'Cliente excluído com sucesso!');
        } else {
            return redirect()->to(base_url('dashboard/clientes'))->with('error', 'Ocorreu um erro ao excluir o cliente.');
        }
    }
}
