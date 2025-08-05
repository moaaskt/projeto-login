<?php

namespace App\Repositories;

use App\Models\ClienteModel;

// 1. A classe agora "herda" tudo da nossa BaseRepository
class ClienteRepository extends BaseRepository
{
    public function __construct()
    {
        // 2. No construtor, definimos qual é o Model específico
        // que este repositório vai usar.
        $this->model = new ClienteModel();
    }

    // E PRONTO!
    // Não precisamos mais dos métodos getClientePorId, getTodosClientes,
    // criarCliente, atualizarCliente e deletarCliente aqui, pois
    // eles já existem no BaseRepository. O código fica limpo!

    // Se você precisar de um método que SÓ existe para clientes,
    // você o adicionaria aqui. Exemplo:
    // public function getClientesComFaturasAtrasadas() { ... }
}
