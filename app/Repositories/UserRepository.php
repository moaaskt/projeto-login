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
            
            // --- ALTERAÇÃO PRINCIPAL ---
            // 3. Adicionamos o 'cliente_id' que agora é recebido do controller.
            //    Isso garante que a "ponte" entre as tabelas seja criada.
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
}
