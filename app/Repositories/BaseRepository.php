<?php

namespace App\Repositories;

use CodeIgniter\Model;

/**
 * Classe abstrata BaseRepository
 *
 * Uma classe 'abstract' não pode ser instanciada diretamente.
 * Ela serve como um modelo para outras classes herdarem.
 *
 * Contém todos os métodos CRUD (Create, Read, Update, Delete)
 * que são comuns a todos os repositórios.
 */
abstract class BaseRepository
{
    /**
     * @var Model
     * A instância do Model específico (ex: ClienteModel, FaturaModel)
     * que será usada pelo repositório filho.
     */
    protected $model;

    /**
     * Busca um registro pelo seu ID (chave primária).
     *
     * @param int $id
     * @return array|object|null
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * Retorna todos os registros da tabela.
     *
     * @return array
     */
    public function findAll(): array
    {
        return $this->model->findAll();
    }

    /**
     * Cria (insere) um novo registro no banco de dados.
     *
     * @param array $data
     * @return int|string|false O ID do novo registro ou false em caso de falha.
     */
    public function create(array $data)
    {
        return $this->model->insert($data);
    }

    /**
     * Atualiza um registro existente pelo seu ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->model->update($id, $data);
    }

    /**
     * Deleta um registro pelo seu ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->model->delete($id);
    }
}
