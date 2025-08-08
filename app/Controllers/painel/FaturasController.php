<?php

namespace App\Controllers\painel;

use App\Controllers\BaseController;
use App\Models\ClienteModel;
use App\Models\FaturaModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class FaturasController extends BaseController
{
    /**
     * Exibe a lista de faturas.
     */
    public function index()
    {
        $faturaModel = new FaturaModel();
        $filters = [
            'status'      => $this->request->getGet('status'),
            'valor_min'   => $this->request->getGet('valor_min'),
            'valor_max'   => $this->request->getGet('valor_max'),
            'data_inicio' => $this->request->getGet('data_inicio'),
            'data_fim'    => $this->request->getGet('data_fim'),
        ];
        $data = [
            'faturas' => $faturaModel->search($filters),
            'pager'   => $faturaModel->pager,
            'stats'   => $faturaModel->getDashboardStatistics(),
            'title'   => 'Minhas Faturas',
            'filters' => $filters
        ];
        return view('painel/faturas/index', $data);
    }

    /**
     * Mostra o formulário para criar uma nova fatura.
     */
     public function nova()
    {
        // ALTERAÇÃO 1: Usar o UsuarioModel em vez do ClienteModel.
        // O nome da variável continua 'clienteModel' para não impactar o resto do código.
        $clienteModel = new \App\Models\UsuarioModel(); 

        $data = [
            // ALTERAÇÃO 2: Buscar na tabela 'usuarios' e filtrar por role 'cliente'.
            'clientes' => $clienteModel->where('role', 'cliente')->findAll(),
            'title'    => 'Nova Fatura'
        ];
        return view('painel/faturas/form', $data);
    }

    /**
     * Mostra o formulário para editar uma fatura existente.
     */
     public function editar($id)
    {
        $faturaModel = new FaturaModel();
        // ALTERAÇÃO 1: Usar o UsuarioModel em vez do ClienteModel.
        $clienteModel = new \App\Models\UsuarioModel(); 

        $data = [
            'fatura'   => $faturaModel->find($id),
            // ALTERAÇÃO 2: Buscar na tabela 'usuarios' e filtrar por role 'cliente'.
            'clientes' => $clienteModel->where('role', 'cliente')->findAll(),
            'title'    => 'Editar Fatura'
        ];
        return view('painel/faturas/form', $data);
    }

    /**
     * Salva uma nova fatura ou atualiza uma existente.
     */
     public function salvar()
    {
        // --- PASSO 1: CONTROLE TOTAL DOS DADOS ---
        // Em vez de passar o $_POST diretamente, vamos construir o array de dados
        // manualmente. Isso nos dá 100% de certeza sobre o que estamos enviando.
        $dadosParaSalvar = [
            'cliente_id'      => $this->request->getPost('cliente_id'),
            'descricao'       => $this->request->getPost('descricao'),
            'valor'           => $this->request->getPost('valor'),
            'data_vencimento' => $this->request->getPost('data_vencimento'),
            'status'          => $this->request->getPost('status'),
        ];

        // Se for uma edição, adicionamos o ID ao array.
        $id = $this->request->getPost('id');
        if (!empty($id)) {
            $dadosParaSalvar['id'] = $id;
        }

        // --- PASSO 2: INSERÇÃO DIRETA E CAPTURA DE ERRO ---
        // Vamos usar o Query Builder para inserir os dados diretamente,
        // bypassando qualquer "mágica" do método save() que possa estar falhando.
        // Isso nos dará um controle absoluto e um erro de banco de dados real se houver um.
        $faturaModel = new FaturaModel();

        try {
            if ($faturaModel->insert($dadosParaSalvar)) {
                // Se a inserção funcionou, redireciona com sucesso.
                return redirect()->to(base_url('dashboard/faturas'))->with('success', 'Fatura salva com sucesso!');
            } else {
                // Se o insert() retornar false, mostramos os erros do model.
                // Isso é nossa rede de segurança final.
                dd($faturaModel->errors());
            }
        } catch (\Exception $e) {
            // Se a tentativa de inserção gerar um erro do banco de dados (ex: tipo de dado errado),
            // nós vamos capturá-lo e mostrá-lo na tela.
            dd("Erro do Banco de Dados: " . $e->getMessage());
        }
    }

    /**
     * Exclui uma fatura.
     */
    public function excluir($id)
    {
        $faturaModel = new FaturaModel();
        if ($faturaModel->delete($id)) {
            return redirect()->to(base_url('dashboard/faturas'))->with('success', 'Fatura excluída com sucesso!');
        } else {
            return redirect()->to(base_url('dashboard/faturas'))->with('error', 'Ocorreu um erro ao excluir a fatura.');
        }
    }

    /**
     * Exibe a página de detalhes de uma fatura.
     */
    public function visualizar($id)
    {
        $faturaModel = new FaturaModel();
        $fatura = $faturaModel
            ->select('faturas.*, clientes.nome_completo as nome_cliente')
            ->join('clientes', 'clientes.id = faturas.cliente_id', 'left')
            ->find($id);

        if ($fatura === null) {
            throw new PageNotFoundException('Não foi possível encontrar a fatura com ID: ' . $id);
        }
        $data = [
            'fatura' => $fatura,
            'title'  => 'Detalhes da Fatura'
        ];
        return view('painel/faturas/visualizar', $data);
    }

    /**
     * Gera uma planilha Excel com os detalhes da fatura.
     */
    public function gerarExcel($id)
    {
        $faturaModel = new FaturaModel();
        $fatura = $faturaModel
            ->select('faturas.*, clientes.nome_completo as nome_cliente')
            ->join('clientes', 'clientes.id = faturas.cliente_id', 'left')
            ->find($id);

        if ($fatura === null) {
            throw new PageNotFoundException('Não foi possível encontrar a fatura com ID: ' . $id);
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Detalhes da Fatura');
        $sheet->setCellValue('A1', 'CAMPO');
        $sheet->setCellValue('B1', 'VALOR');
        $sheet->setCellValue('A2', 'ID da Fatura');
        $sheet->setCellValue('B2', $fatura['id']);
        $sheet->setCellValue('A3', 'Cliente');
        $sheet->setCellValue('B3', $fatura['nome_cliente']);
        $sheet->setCellValue('A4', 'Descrição');
        $sheet->setCellValue('B4', $fatura['descricao']);
        $sheet->setCellValue('A5', 'Valor');
        $sheet->setCellValue('B5', $fatura['valor']);
        $sheet->setCellValue('A6', 'Data de Vencimento');
        $sheet->setCellValue('B6', date('d/m/Y', strtotime($fatura['data_vencimento'])));
        $sheet->setCellValue('A7', 'Status');
        $sheet->setCellValue('B7', $fatura['status']);
        $sheet->getStyle('A1:B1')->getFont()->setBold(true);
        $writer = new Xlsx($spreadsheet);
        $fileName = 'fatura_' . $fatura['id'] . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }
}