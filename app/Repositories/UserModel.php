<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // Nome da tabela no banco de dados
    protected $table = 'users'; 

    // Chave primária da tabela
    protected $primaryKey = 'id';

    // Campos que podem ser preenchidos
    protected $allowedFields = ['name', 'email', 'password'];
}
