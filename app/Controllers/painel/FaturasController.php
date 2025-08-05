<?php

namespace App\Controllers\painel;

use App\Controllers\BaseController;
use App\Models\ClienteModel;
use App\Models\FaturaModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

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
        $clienteModel = new ClienteModel();
        $data = [
            'clientes' => $clienteModel->findAll(),
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
        $clienteModel = new ClienteModel();
        $data = [
            'fatura'   => $faturaModel->find($id),
            'clientes' => $clienteModel->findAll(),
            'title'    => 'Editar Fatura'
        ];
        return view('painel/faturas/form', $data);
    }

    /**
     * Salva uma nova fatura ou atualiza uma existente.
     */
    public function salvar()
    {
        $faturaModel = new FaturaModel();
        $dados = $this->request->getPost();

        if ($faturaModel->save($dados)) {
            return redirect()->to(base_url('dashboard/faturas'))->with('success', 'Fatura salva com sucesso!');
        } else {
            return redirect()->back()->withInput()->with('errors', $faturaModel->errors());
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