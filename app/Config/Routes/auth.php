<?php


// Rota para MOSTRAR o formulário de cadastro
$routes->get('cadastro', 'auth\cadastro\Cadastro::index');

// Rota para PROCESSAR os dados do formulário de cadastro
$routes->post('cadastro/salvar', 'auth\cadastro\Cadastro::store');




$routes->post('login/auth', 'auth\login\Login::auth');
$routes->get('logout', 'auth\login\Login::logout');