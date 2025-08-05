<?php

namespace App\Repositories;

use App\Models\UsuarioModel;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new UsuarioModel();
    }

    /**
     * Este é um método específico de usuário, então ele permanece aqui.
     */
    public function getUsuarioPorEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * Sobrescrevemos o método 'create' da BaseRepository
     * para adicionar a lógica de hash da senha, que é
     * uma regra de negócio específica da criação de usuários.
     */
    public function create(array $dados): int|string|false
    {
        $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
        return parent::create($dados); // Chama o método 'create' original da BaseRepository
    }
}
