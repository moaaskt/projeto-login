<?php

namespace App\Repositories;

use App\Models\ClienteModel;

class ClienteRepository
{
    /**
     * @var ClienteModel
     * Propriedade para guardar a instância do nosso ClienteModel.
     */
    private $clienteModel;

    public function __construct()
    {
        // Instancia o Model para que possamos usá-lo em todos os métodos.
        $this->clienteModel = new ClienteModel();
    }

    /**
     * Busca um cliente específico pelo seu ID.
     *
     * @param int $id O ID do cliente.
     * @return array|null Retorna os dados do cliente ou nulo.
     */
    public function getClientePorId(int $id)
    {
        return $this->clienteModel->find($id);
    }

    /**
     * Retorna uma lista com todos os clientes cadastrados.
     *
     * @return array
     */
    public function getTodosClientes()
    {
        // O método findAll() do Model busca todos os registros.
        return $this->clienteModel->findAll();
    }

    /**
     * Cria um novo cliente no banco de dados.
     *
     * @param array $dados Os dados do novo cliente.
     * @return int|false Retorna o ID do novo cliente ou false em caso de falha.
     */
    public function criarCliente(array $dados)
    {
        // O método insert() retorna o ID do novo registro.
        return $this->clienteModel->insert($dados);
    }

    /**
     * Atualiza os dados de um cliente existente.
     *
     * @param int $id O ID do cliente a ser atualizado.
     * @param array $dados Os novos dados do cliente.
     * @return bool Retorna true se a atualização foi bem-sucedida.
     */
    public function atualizarCliente(int $id, array $dados)
    {
        return $this->clienteModel->update($id, $dados);
    }

    /**
     * Deleta um cliente do banco de dados.
     *
     * @param int $id O ID do cliente a ser deletado.
     * @return bool Retorna true se a deleção foi bem-sucedida.
     */
    public function deletarCliente(int $id)
    {
        return $this->clienteModel->delete($id);
    }
}
