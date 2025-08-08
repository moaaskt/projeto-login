<?php

namespace App\Repositories;

use App\Models\UsuarioModel;

class UserRepository
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    /**
     * Cria um novo usuário, cuidando da lógica de negócio como o hash da senha.
     *
     * @param array $dados Dados vindos do formulário (agora incluindo o cliente_id)
     * @return bool Retorna true se o usuário foi criado, false se não.
     */
    public function criarUsuario(array $dados): bool
    {
        // 1. Prepara os dados para salvar
        $dadosParaSalvar = [
            'nome'   => $dados['nome'],
            'email'  => $dados['email'],
            // 2. A lógica de negócio (hash da senha) continua aqui
            'senha'  => password_hash($dados['senha'], PASSWORD_DEFAULT),
            
            // 3. Adicionamos o 'cliente_id' que agora é recebido do controller.
            'cliente_id' => $dados['cliente_id'],
        ];

        // 4. Usa o Model para inserir no banco
        if ($this->usuarioModel->insert($dadosParaSalvar)) {
            return true;
        }

        return false;
    }

    /**
     * Busca um usuário pelo seu endereço de e-mail.
     *
     * @param string $email
     * @return array|null Retorna os dados do usuário ou nulo se não encontrar.
     */
    public function getUsuarioPorEmail(string $email): ?array
    {
        return $this->usuarioModel->where('email', $email)->first();
    }


    // ====================================================================
    // == MÉTODOS ADICIONADOS PARA RESOLVER O ERRO NO LOGINCONTROLLER ==
    // ====================================================================

    /**
     * Repassa a chamada do método 'update' para o UsuarioModel.
     * Isso permite que o controller use $repo->update() diretamente.
     *
     * @param int|string $id O ID do registro a ser atualizado.
     * @param array $data Os dados para atualização.
     * @return bool
     */
    public function update($id, $data)
    {
        return $this->usuarioModel->update($id, $data);
    }

    /**
     * Repassa a chamada do método 'where' para o UsuarioModel.
     * Isso permite o encadeamento de métodos como $repo->where(...)->first().
     *
     * @param string $column O nome da coluna.
     * @param mixed $value O valor a ser comparado.
     * @return \CodeIgniter\Model Retorna a instância do Model para permitir o encadeamento.
     */
    public function where(string $column, $value)
    {
        // Retorna a própria instância do model para que outros métodos
        // como ->where() ou ->first() possam ser chamados em sequência.
        return $this->usuarioModel->where($column, $value);
    }

       /**
     * Repassa a chamada do método 'find' para o UsuarioModel.
     *
     * @param int|string $id O ID do registro a ser encontrado.
     * @return mixed
     */
    public function find($id)
    {
        return $this->usuarioModel->find($id);
    }


}
