<?php

namespace App\Controllers\painel\dashboard;

use App\Controllers\BaseController;
use App\Models\ClienteModel; // Pode remover esta linha se quiser, pois não é mais usada aqui
use App\Models\FaturaModel;

class Dashboard extends BaseController
{
    protected $session;
    protected $usuarioData;

    public function __construct()
    {
        $this->session = session();
        $this->usuarioData = $this->session->get('usuario');
    }

    public function index()
    {
        $data['email'] = $this->usuarioData['email'] ?? 'E-mail não encontrado';
        $data['title'] = 'Dashboard Principal';
        return view('painel/dashboard/index', $data);
    }
    
    // --- MÉTODOS DE FATURAS ---
    public function faturas()
    {
        $faturaModel = new FaturaModel();
        $data = [
            'faturas' => $faturaModel
                ->select('faturas.*, clientes.nome_completo as nome_cliente')
                ->join('clientes', 'clientes.id = faturas.cliente_id', 'left')
                ->findAll(),
            'title'   => 'Minhas Faturas'
        ];
        return view('painel/faturas/index', $data);
    }

    public function novaFatura()
    {
        $clienteModel = new ClienteModel();
        $data = [
            'clientes' => $clienteModel->findAll(),
            'title'    => 'Nova Fatura'
        ];
        return view('painel/faturas/form', $data);
    }

    public function editarFatura($id)
    {
        $faturaModel = new FaturaModel();
        $clienteModel = new ClienteModel();
        $data = [
            'fatura'   => $faturaModel->find($id),
            'clientes' => $clienteModel->findAll(),
            'title'    => 'Editar Fatura'
        ];
        return view('painel/faturas/form', $data);
    }

    public function salvarFatura()
    {
        $faturaModel = new FaturaModel();
        $dados = [
            'id'              => $this->request->getPost('id'),
            'cliente_id'      => $this->request->getPost('cliente_id'),
            'descricao'       => $this->request->getPost('descricao'),
            'valor'           => $this->request->getPost('valor'),
            'data_vencimento' => $this->request->getPost('data_vencimento'),
            'status'          => $this->request->getPost('status'),
        ];
        if (empty($dados['id'])) {
            unset($dados['id']);
        }
        if ($faturaModel->save($dados)) {
            return redirect()->to(base_url('dashboard/faturas'))->with('success', 'Fatura salva com sucesso!');
        } else {
            return redirect()->back()->withInput()->with('errors', $faturaModel->errors());
        }
    }

    public function excluirFatura($id)
    {
        $faturaModel = new FaturaModel();
        if ($faturaModel->delete($id)) {
            return redirect()->to(base_url('dashboard/faturas'))->with('success', 'Fatura excluída com sucesso!');
        } else {
            return redirect()->to(base_url('dashboard/faturas'))->with('error', 'Ocorreu um erro ao excluir a fatura.');
        }
    }

    // --- MÉTODO DE PERFIL ---
    public function perfil()
    {
        $data['title'] = 'Meu Perfil';
        return view('painel/perfil/index', $data);
    }
}