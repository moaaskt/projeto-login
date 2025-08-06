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



    
}
