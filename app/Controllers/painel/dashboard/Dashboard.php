<?php

namespace App\Controllers\painel\dashboard;

use App\Controllers\BaseController;
use App\Models\ClienteModel;
use App\Models\FaturaModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;



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

        // Coleta todos os possíveis filtros da URL (método GET)
        $filters = [
            'status'      => $this->request->getGet('status'),
            'valor_min'   => $this->request->getGet('valor_min'),
            'valor_max'   => $this->request->getGet('valor_max'),
            'data_inicio' => $this->request->getGet('data_inicio'),
            'data_fim'    => $this->request->getGet('data_fim'),
        ];

        $data = [
            // Passa os filtros para o novo método de busca do Model
            'faturas' => $faturaModel->search($filters),
            'pager'   => $faturaModel->pager, // A paginação continua funcionando
            'stats'   => $faturaModel->getDashboardStatistics(), // Pega as estatísticas
            'title'   => 'Minhas Faturas',
            'filters' => $filters // Devolve os filtros para a View para preencher o formulário
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

    public function visualizarFatura($id)
    {
        $faturaModel = new FaturaModel();

        // Buscamos a fatura já com o nome do cliente usando o JOIN
        $fatura = $faturaModel
            ->select('faturas.*, clientes.nome_completo as nome_cliente')
            ->join('clientes', 'clientes.id = faturas.cliente_id', 'left')
            ->find($id);

        // Se a fatura não for encontrada, mostra um erro 404
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

        // 1. Cria um novo objeto de planilha
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Detalhes da Fatura');

        // 2. Define os cabeçalhos e os dados
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

        // 3. Estiliza o cabeçalho (negrito)
        $sheet->getStyle('A1:B1')->getFont()->setBold(true);

        // 4. Cria o "escritor" para o formato Xlsx (Excel)
        $writer = new Xlsx($spreadsheet);
        $fileName = 'fatura_' . $fatura['id'] . '.xlsx';

        // 5. Define os cabeçalhos HTTP para forçar o download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        // 6. Envia o arquivo para o navegador
        $writer->save('php://output');
        exit();
    }




    // --- MÉTODO DE PERFIL ---
    public function perfil()
    {
        $data['title'] = 'Meu Perfil';
        return view('painel/perfil/index', $data);
    }
}
