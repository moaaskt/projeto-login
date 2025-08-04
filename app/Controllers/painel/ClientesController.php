<?php

namespace App\Controllers\painel;

use App\Controllers\BaseController;
use App\Models\ClienteModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Dompdf\Dompdf;
use Dompdf\Options;

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
            'pager'    => $clienteModel->pager,
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


    /**
     * Exibe a página de detalhes de um cliente.
     */
    public function visualizar($id)
    {
        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->find($id);

        // Boa prática: se o cliente não for encontrado, mostra uma página de erro 404
        if ($cliente === null) {
            throw new PageNotFoundException('Não foi possível encontrar o cliente com ID: ' . $id);
        }

        $data = [
            'cliente' => $cliente,
            'title'   => 'Detalhes do Cliente'
        ];

        return view('painel/clientes/visualizar', $data);
    }

    /**
     * Gera e exibe um PDF com os detalhes do cliente.
     */
    public function gerarPdf($id)
    {
        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->find($id);

        if ($cliente === null) {
            throw new PageNotFoundException('Não foi possível encontrar o cliente com ID: ' . $id);
        }

        // Preparando o HTML que será convertido em PDF
        $dataCadastro = date('d/m/Y H:i', strtotime($cliente['created_at']));
        $html = "
            <style>
                body { font-family: sans-serif; font-size: 12px; }
                h1 { color: #2c3e50; border-bottom: 2px solid #ccc; padding-bottom: 5px;}
                h3 { margin-top: 20px; margin-bottom: 5px; color: #34495e;}
                dl { border: 1px solid #eee; padding: 10px; border-radius: 5px; }
                dt { font-weight: bold; float: left; width: 150px; clear: left; }
                dd { margin-left: 160px; margin-bottom: 10px; }
                .logo { vertical-align: middle; }
            </style>
            <h1>
                <img src='https://doardigital.com.br/wp-content/uploads/2022/11/Webp.net-resizeimage-1.png' width='40px' class='logo'> 
                Detalhes do Cliente
            </h1>
            
            <h3>" . esc($cliente['nome_completo']) . "</h3>
            <dl>
                <dt>E-mail:</dt><dd>" . esc($cliente['email'] ?: 'Não informado') . "</dd>
                <dt>Telefone:</dt><dd>" . esc($cliente['telefone'] ?: 'Não informado') . "</dd>
                <dt>CPF/CNPJ:</dt><dd>" . esc($cliente['cpf_cnpj'] ?: 'Não informado') . "</dd>
                <dt>Cliente desde:</dt><dd>" . $dataCadastro . "</dd>
            </dl>

            <h3>Endereço</h3>
            <dl>
                <dt>Endereço Completo:</dt><dd>" . esc($cliente['endereco'] ?: 'Não informado') . "</dd>
                <dt>CEP:</dt><dd>" . esc($cliente['cep'] ?: 'Não informado') . "</dd>
            </dl>
        ";

        // Configurações do Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        // Instancia o Dompdf
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Exibe o PDF no navegador
        $dompdf->stream("detalhes_cliente_" . $cliente['id'] . ".pdf", ["Attachment" => false]);
    }
}
