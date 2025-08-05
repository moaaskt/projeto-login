<?php

namespace App\Repositories;

use App\Models\UsuarioModel;

// O nome da classe agora reflete a entidade que ela gerencia: Usuário.
class UserRepository
{
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    /**
     * Busca um usuário no banco de dados pelo seu e-mail.
     * (Este método continua igual)
     */
    public function getUsuarioPorEmail(string $email)
    {
        return $this->usuarioModel->where('email', $email)->first();
    }

    /**
     * **NOVO MÉTODO**
     * Cria um novo usuário no banco de dados.
     *
     * @param array $dados Os dados do novo usuário (ex: ['nome' => '...', 'email' => '...', 'senha' => '...'])
     * @return bool Retorna true se a inserção foi bem-sucedida, false caso contrário.
     */
    public function criarUsuario(array $dados)
    {
        // Medida de segurança ESSENCIAL:
        // Nunca salve a senha como texto puro. Usamos password_hash()
        // para criar uma versão criptografada e segura da senha.
        $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);

        // O método insert() do Model do CodeIgniter cuida da criação.
        // Ele retorna true em caso de sucesso.
        return $this->usuarioModel->insert($dados);
    }
}
