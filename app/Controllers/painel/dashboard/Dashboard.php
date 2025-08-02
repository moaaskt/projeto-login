<?php

namespace App\Controllers\painel\dashboard;

use App\Controllers\BaseController;
use App\Models\ClienteModel;
use App\Models\FaturaModel;


class Dashboard extends BaseController
{
    
    public function index()
    {
        $session = session();
        $data['email'] = $session->get('usuario')['email'];
        $data['title'] = 'Dashboard Principal';
        return view('painel/dashboard/index', $data);
    }

   

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
        $faturaModel = new FaturaModel();

        // IMPORTANTE: Aqui fazemos um "JOIN" para buscar o nome do cliente
        // junto com os dados da fatura.
        $data = [
            'faturas' => $faturaModel
                ->select('faturas.*, clientes.nome_completo as nome_cliente')
                ->join('clientes', 'clientes.id = faturas.cliente_id')
                ->findAll(),
            'title'   => 'Minhas Faturas'
        ];

        return view('painel/faturas/index', $data);
    }

    /**
     * Mostra o formulário para criar uma nova fatura.
     * Precisamos buscar todos os clientes para listá-los no formulário.
     */
    public function novaFatura()
    {
        $clienteModel = new ClienteModel();
        $data = [
            'clientes' => $clienteModel->findAll(), // Busca todos os clientes
            'title'    => 'Nova Fatura'
        ];
        return view('painel/faturas/form', $data);
    }

    /**
     * Mostra o formulário para editar uma fatura existente.
     */
    public function editarFatura($id)
    {
        $faturaModel = new FaturaModel();
        $clienteModel = new ClienteModel();

        $data = [
            'fatura'   => $faturaModel->find($id),    // Busca a fatura específica
            'clientes' => $clienteModel->findAll(), // Busca todos os clientes para o dropdown
            'title'    => 'Editar Fatura'
        ];
        return view('painel/faturas/form', $data);
    }

    /**
     * Salva uma nova fatura ou atualiza uma existente.
     */
    public function salvarFatura()
    {
        $faturaModel = new FaturaModel();
        $dados = $this->request->getPost();

        if ($faturaModel->save($dados)) {
            return redirect()->to(base_url('dashboard/faturas'))->with('success', 'Fatura salva com sucesso!');
        } else {
            // Se houver erros de validação, eles podem ser tratados aqui
            return redirect()->back()->withInput()->with('error', 'Ocorreu um erro ao salvar a fatura.');
        }
    }

    /**
     * Exclui uma fatura.
     */
    public function excluirFatura($id)
    {
        $faturaModel = new FaturaModel();
        if ($faturaModel->delete($id)) {
            return redirect()->to(base_url('dashboard/faturas'))->with('success', 'Fatura excluída com sucesso!');
        } else {
            return redirect()->to(base_url('dashboard/faturas'))->with('error', 'Ocorreu um erro ao excluir a fatura.');
        }
    }
}
