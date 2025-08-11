<?php

namespace App\Controllers\painel;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class PerfilController extends BaseController
{
    protected $session;
    protected $usuarioData;
    protected $usuarioModel;

    public function __construct()
    {
        $this->session = session();
        $this->usuarioData = $this->session->get('usuario');
        $this->usuarioModel = new UsuarioModel();
    }

    /**
     * Exibe a página principal do perfil do usuário.
     */
    public function index()
    {
        // Se a sessão for perdida por algum motivo, desloga
        if (empty($this->usuarioData)) {
            return redirect()->to(base_url('logout'));
        }

        $data = [
            'title'   => 'Meu Perfil',
            'usuario' => $this->usuarioModel->find($this->usuarioData['id'])
        ];

        return view('painel/perfil/index', $data);
    }

    /**
     * Atualiza os dados cadastrais (nome, email) do usuário.
     */
    public function atualizarDados()
    {
        $idUsuario = $this->usuarioData['id'];

        $regras = [
            'nome'  => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[usuarios.email,id,{$idUsuario}]",
        ];

        if (!$this->validate($regras)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dados = [
            'id'    => $idUsuario,
            'nome'  => $this->request->getPost('nome'),
            'email' => $this->request->getPost('email'),
        ];

        if ($this->usuarioModel->save($dados)) {
            // Importante: Atualizar os dados da sessão após a alteração
            $this->regenerateUserSession($idUsuario);
            return redirect()->to(base_url('cliente/perfil'))->with('success', 'Dados atualizados com sucesso!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Ocorreu um erro ao atualizar os dados.');
        }
    }

    /**
     * Atualiza a senha do usuário.
     */
    public function alterarSenha()
    {
        $idUsuario = $this->usuarioData['id'];
        $usuario = $this->usuarioModel->find($idUsuario);

        $regras = [
            'senha_atual'     => 'required',
            'nova_senha'      => 'required|min_length[8]',
            'confirmar_senha' => 'required|matches[nova_senha]'
        ];

        if (!$this->validate($regras)) {
            return redirect()->back()->withInput()->with('errors-senha', $this->validator->getErrors());
        }

        // Verifica se a senha atual está correta
        if (!password_verify($this->request->getPost('senha_atual'), $usuario['senha'])) {
            return redirect()->back()->with('error-senha', 'A senha atual está incorreta.');
        }

        $dados = [
            'id'    => $idUsuario,
            'senha' => password_hash($this->request->getPost('nova_senha'), PASSWORD_DEFAULT)
        ];

        if ($this->usuarioModel->save($dados)) {
            return redirect()->to(base_url('cliente/perfil'))->with('success-senha', 'Senha alterada com sucesso!');
        } else {
            return redirect()->back()->with('error-senha', 'Ocorreu um erro ao alterar a senha.');
        }
    }
    
    /**
     * Helper privado para regenerar os dados da sessão do usuário.
     * Isso é importante após atualizações de dados do usuário para garantir que a sessão esteja sempre atualizada.
     */
    private function regenerateUserSession($id)
    {
        $usuario = $this->usuarioModel->find($id);
        unset($usuario['senha']);

        // Preservar o estado de logged_in atual
        $logged_in = $this->session->get('logged_in') ?? true;
        
        $sessionData = [
            'usuario'   => $usuario,
            'logged_in' => $logged_in,
        ];
        
        // Atualizar a sessão sem regenerar o ID da sessão
        $this->session->set($sessionData);
    }
}