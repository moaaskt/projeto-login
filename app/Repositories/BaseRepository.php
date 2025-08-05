<?php

namespace App\Repositories;

use CodeIgniter\Model;

/**
 * Classe abstrata BaseRepository com suporte a multi-tenant.
 */
abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var int|null
     */
    protected $tenantId;

    public function __construct()
    {
        $this->tenantId = session('tenant_id');
    }

    /**
     * Busca um único registro pelo ID, considerando o tenant.
     */
    public function find(int $id)
    {
        return $this->model
            ->where('id', $id)
            ->where('tenant_id', $this->tenantId)
            ->first();
    }

    /**
     * Retorna todos os registros do tenant atual.
     */
    public function findAll(): array
    {
        return $this->model
            ->where('tenant_id', $this->tenantId)
            ->findAll();
    }

    /**
     * Cria um novo registro com tenant_id injetado automaticamente.
     */
    public function create(array $data)
    {
        $data['tenant_id'] = $this->tenantId;
        return $this->model->insert($data);
    }

    /**
     * Atualiza um registro, verificando se pertence ao tenant.
     */
    public function update(int $id, array $data): bool
    {
        return $this->model
            ->where('id', $id)
            ->where('tenant_id', $this->tenantId)
            ->set($data)
            ->update();
    }

    /**
     * Deleta um registro, garantindo que pertença ao tenant.
     */
    public function delete(int $id): bool
    {
        return $this->model
            ->where('id', $id)
            ->where('tenant_id', $this->tenantId)
            ->delete();
    }
}
