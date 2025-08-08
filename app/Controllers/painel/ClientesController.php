<?php

namespace App\Controllers\painel;

use App\Controllers\BaseController;
use App\Models\ClienteModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Dompdf\Dompdf;
use Dompdf\Options;
use chillerlan\QRCode\{QRCode, QROptions};


class ClientesController extends BaseController
{
    /**
     * Exibe a lista de clientes.
     */
    public function index()
    {
        $clienteModel = new ClienteModel();
        $filters = [
            'termo' => $this->request->getGet('termo'),
            'data_cadastro' => $this->request->getGet('data_cadastro'),
        ];
        $filters = array_filter($filters);
        $clientes = $clienteModel->search($filters);
        $pager = $clienteModel->pager;

        return view('painel/clientes/index', [
            'clientes' => $clientes,
            'filters' => $filters,
            'pager' => $pager
        ]);
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
        $clienteModel = new \App\Models\ClienteModel();
        $dados = $this->request->getPost([
            'id', 'nome_completo', 'email', 'telefone', 'cpf_cnpj', 'cep',
            'logradouro', 'numero', 'bairro', 'cidade', 'estado', 'data_nascimento',
        ]);
        
        if ($clienteModel->save($dados)) {
            $senhaTemporaria = null;
            if ($this->request->getPost('criar_acesso') && empty($dados['id'])) {
                $novoClienteId = $clienteModel->getInsertID();
                $senhaTemporaria = $this->_criarAcessoPortal($novoClienteId, $dados);
            }

            $mensagem = 'Cliente salvo com sucesso!';
            if ($senhaTemporaria) {
                $mensagem .= " Acesso ao portal criado com a senha temporária: <strong>{$senhaTemporaria}</strong>. Por favor, informe o cliente.";
            }
            return redirect()->to(base_url('dashboard/clientes'))->with('success', $mensagem);
        } else {
            return redirect()->back()->withInput()->with('errors', $clienteModel->errors());
        }
    }


    /**
     * Cria um registro na tabela 'usuarios' e RETORNA a senha temporária.
     * @return string A senha temporária gerada.
     */
    private function _criarAcessoPortal($clienteId, $dadosCliente): string
    {
        $usuarioModel = new \App\Models\UsuarioModel();
        $senhaTemporaria = bin2hex(random_bytes(4)); // 8 caracteres

        $dadosUsuario = [
            'cliente_id' => $clienteId,
            'nome'       => $dadosCliente['nome_completo'],
            'email'      => $dadosCliente['email'],
            'senha'      => password_hash($senhaTemporaria, PASSWORD_DEFAULT),
            'role'       => 'cliente',

            // ====================================================================
            // == IMPLEMENTAÇÃO ADICIONADA AQUI ==
            // Esta linha marca o usuário para que ele seja forçado a trocar
            // a senha no seu primeiro login.
            // ====================================================================
            'must_change_password' => 1,
        ];

        $usuarioModel->insert($dadosUsuario);

        return $senhaTemporaria;
    }


    /**
     * Verifica via AJAX se um e-mail já existe na tabela de usuários.
     * Retorna uma resposta JSON.
     */
    public function checkEmail()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403, 'Acesso Negado');
        }
        $email = $this->request->getPost('email');
        $idAtual = $this->request->getPost('id');
        $clienteModel = new \App\Models\ClienteModel();
        $query = $clienteModel->withDeleted()->where('email', $email);
        if (!empty($idAtual)) {
            $query->where('id !=', $idAtual);
        }
        $clienteExistente = $query->first();
        return $this->response->setJSON(['exists' => ($clienteExistente !== null)]);
    }


    /**
     * Verifica via AJAX se um CPF/CNPJ já existe na tabela de clientes.
     * Retorna uma resposta JSON.
     */
    public function checkCpfCnpj()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403, 'Acesso Negado');
        }
        $cpfCnpj = $this->request->getPost('cpf_cnpj');
        $idAtual = $this->request->getPost('id');
        $cpfCnpjLimpo = preg_replace('/[^0-9]/', '', (string) $cpfCnpj);
        if (empty($cpfCnpjLimpo)) {
            return $this->response->setJSON(['exists' => false]);
        }
        $clienteModel = new \App\Models\ClienteModel();
        $query = $clienteModel->withDeleted()->where('cpf_cnpj', $cpfCnpjLimpo);
        if (!empty($idAtual)) {
            $query->where('id !=', $idAtual);
        }
        $clienteExistente = $query->first();
        return $this->response->setJSON(['exists' => ($clienteExistente !== null)]);
    }


  /**
 * Exclui um cliente e o seu acesso de usuário associado de forma segura.
 */
public function excluir($id)
{
    $clienteModel = new \App\Models\ClienteModel();
    $usuarioModel = new \App\Models\UsuarioModel();

    // 1. Obtemos a conexão com o banco de dados para usar transações.
    //    Isso garante que ou ambas as exclusões funcionam, ou nenhuma delas.
    $db = \Config\Database::connect();
    $db->transStart();

    // 2. Encontra o usuário associado ao cliente que será excluído.
    $usuario = $usuarioModel->where('cliente_id', $id)->first();

    // 3. Se um usuário for encontrado, ele é excluído permanentemente.
    if ($usuario) {
        // O segundo parâmetro `true` força uma exclusão permanente (hard delete),
        // que apaga a linha do banco e libera o e-mail para ser usado novamente.
        $usuarioModel->delete($usuario['id'], true);
    }

    // 4. Exclui o cliente da tabela de clientes (soft ou hard delete, conforme seu model).
    $clienteModel->delete($id);

    // 5. Finaliza a transação.
    if ($db->transStatus() === false) {
        // Se algo deu errado, desfaz tudo para não corromper os dados.
        $db->transRollback();
        return redirect()->to(base_url('dashboard/clientes'))->with('error', 'Ocorreu um erro ao excluir o cliente e seu acesso.');
    } else {
        // Se tudo correu bem, confirma as alterações no banco.
        $db->transCommit();
        return redirect()->to(base_url('dashboard/clientes'))->with('success', 'Cliente e seu acesso ao portal foram excluídos com sucesso!');
    }
}
    // ... Seus outros métodos (importar, gerarModeloExcel, visualizar, gerarPdf) continuam aqui sem alterações ...
    public function importar()
    {
        $file = $this->request->getFile('excel_file');
        $clienteModel = new ClienteModel();

        if ($file === null || !$file->isValid() || $file->getExtension() !== 'xlsx') {
            return redirect()->to(base_url('dashboard/clientes'))->with('error', 'Arquivo inválido. Apenas .xlsx são permitidos.');
        }

        try {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($file->getTempName());
            $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            $clientesParaInserir = [];
            $clientesParaAtualizar = [];
            $countSucesso = 0;
            $countAtualizado = 0;
            $countFalha = 0;

            $isHeader = true;
            foreach ($sheet as $row) {
                if ($isHeader) {
                    $isHeader = false;
                    continue;
                }

                $clienteData = [
                    'nome_completo'   => $row['A'] ?? null,
                    'cpf_cnpj'        => $row['B'] ?? null,
                    'email'           => $row['C'] ?? null,
                    'telefone'        => $row['D'] ?? null,
                    'logradouro'      => $row['E'] ?? null,
                    'numero'          => $row['F'] ?? null,
                    'bairro'          => $row['G'] ?? null,
                    'cidade'          => $row['H'] ?? null,
                    'estado'          => $row['I'] ?? null,
                    'cep'             => $row['J'] ?? null,
                    'data_nascimento' => $row['K'] ?? null,
                ];

                if (empty($clienteData['nome_completo'])) {
                    $countFalha++;
                    continue;
                }

                $clienteExistente = null;
                if (!empty($clienteData['email']) || !empty($clienteData['cpf_cnpj'])) {
                    $clienteExistente = $clienteModel->withDeleted()
                        ->groupStart()
                        ->where('email', $clienteData['email'])
                        ->orWhere('cpf_cnpj', $clienteData['cpf_cnpj'])
                        ->groupEnd()
                        ->first();
                }

                if ($clienteExistente) {
                    $clienteData['id'] = $clienteExistente['id'];
                    $clienteData['deleted_at'] = null;
                    $clientesParaAtualizar[] = $clienteData;
                    $countAtualizado++;
                } else {
                    $clientesParaInserir[] = $clienteData;
                    $countSucesso++;
                }
            }

            if (!empty($clientesParaAtualizar)) {
                $clienteModel->updateBatch($clientesParaAtualizar, 'id');
            }
            if (!empty($clientesParaInserir)) {
                $clienteModel->insertBatch($clientesParaInserir);
            }

            return redirect()->to(base_url('dashboard/clientes'))
                ->with('success', "$countSucesso clientes novos importados, $countAtualizado clientes reativados/atualizados. $countFalha linhas ignoradas.");
        } catch (\Exception $e) {
            return redirect()->to(base_url('dashboard/clientes'))->with('error', 'Ocorreu um erro ao processar o arquivo: ' . $e->getMessage());
        }
    }

    public function gerarModeloExcel()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Modelo de Importação');

        $headers = [
            'nome_completo', 'cpf_cnpj', 'email', 'telefone', 'logradouro',
            'numero', 'bairro', 'cidade', 'estado', 'cep',
            'data_nascimento (formato AAAA-MM-DD)',
        ];
        $sheet->fromArray($headers, null, 'A1');

        $headerStyle = $sheet->getStyle('A1:K1');
        $headerStyle->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE));
        $headerStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('4F46E5');

        foreach (range('A', 'K') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'modelo_importacao_clientes.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }

    public function visualizar($id)
    {
        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->find($id);

        if ($cliente === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Não foi possível encontrar o cliente com ID: ' . $id);
        }

        $vcard = "BEGIN:VCARD\n";
        $vcard .= "VERSION:3.0\n";
        $vcard .= "FN:" . esc($cliente['nome_completo']) . "\n";
        $vcard .= "TEL;TYPE=CELL:" . esc($cliente['telefone']) . "\n";
        $vcard .= "EMAIL:" . esc($cliente['email']) . "\n";
        $vcard .= "END:VCARD";

        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'   => QRCode::ECC_L,
            'scale'      => 5,
        ]);

        $qrCodeDataUri = (new QRCode($options))->render($vcard);

        $data = [
            'cliente'       => $cliente,
            'title'         => 'Detalhes do Cliente',
            'qrCodeDataUri' => $qrCodeDataUri,
        ];

        return view('painel/clientes/visualizar', $data);
    }

    public function gerarPdf($id)
    {
        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->find($id);

        if ($cliente === null) {
            throw new PageNotFoundException('Não foi possível encontrar o cliente com ID: ' . $id);
        }

        $dataCadastro = date('d/m/Y H:i', strtotime($cliente['created_at']));
        $enderecoCompleto = esc($cliente['logradouro'] ?: 'Não informado');
        if (!empty($cliente['numero'])) {
            $enderecoCompleto .= ', ' . esc($cliente['numero']);
        }
        if (!empty($cliente['bairro'])) {
            $enderecoCompleto .= ' - ' . esc($cliente['bairro']);
        }
        $cidadeEstado = esc($cliente['cidade'] ?: 'Não informada') . ' - ' . esc($cliente['estado'] ?: 'NI');

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
                <dt>Endereço Completo:</dt><dd>" . $enderecoCompleto . "</dd>
                <dt>Cidade/UF:</dt><dd>" . $cidadeEstado . "</dd>
                <dt>CEP:</dt><dd>" . esc($cliente['cep'] ?: 'Não informado') . "</dd>
            </dl>
        ";

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream("detalhes_cliente_" . $cliente['id'] . ".pdf", ["Attachment" => false]);
    }
}
