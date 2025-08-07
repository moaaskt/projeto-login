<?php

namespace App\Repositories;

use App\Models\ClienteModel;

// A classe continua herdando tudo da sua BaseRepository
class ClienteRepository extends BaseRepository
{
    public function __construct()
    {
        // No construtor, definimos o Model específico.
        $this->model = new ClienteModel();
    }

    // --- MÉTODO FALTANTE ADICIONADO ---
    /**
     * Insere um novo registro no banco de dados.
     * Este método delega a chamada para o model interno.
     *
     * @param array $data
     * @return bool|int|string
     */
    public function insert(array $data)
    {
        return $this->model->insert($data);
    }

    /**
     * Retorna o ID do último registro inserido por este repositório.
     * Essencial para fazer a ligação com a tabela de usuários.
     *
     * @return int|null
     */
    public function getLastInsertID()
    {
        // O model do CodeIgniter nos dá acesso direto ao ID.
        return $this->model->getInsertID();
    }
}
