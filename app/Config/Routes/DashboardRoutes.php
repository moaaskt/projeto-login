<?php

$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
    // Rota principal do painel
    $routes->get('', 'painel\dashboard\Dashboard::index');

    // Rotas de Clientes (CRUD)
    $routes->get('clientes', 'painel\dashboard\Dashboard::clientes'); // Listar
    $routes->get('clientes/novo', 'painel\dashboard\Dashboard::novoCliente'); // Formulário de novo
    $routes->get('clientes/editar/(:num)', 'painel\dashboard\Dashboard::editarCliente/$1'); // Formulário de edição
    $routes->post('clientes/salvar', 'painel\dashboard\Dashboard::salvarCliente'); // Ação de salvar (novo ou edição)
    $routes->get('clientes/excluir/(:num)', 'painel\dashboard\Dashboard::excluirCliente/$1'); // Ação de excluir

     // Rotas de Faturas (CRUD ) 
    $routes->get('faturas', 'painel\dashboard\Dashboard::faturas'); // Listar
    $routes->get('faturas/nova', 'painel\dashboard\Dashboard::novaFatura'); // Formulário de nova
    $routes->get('faturas/editar/(:num)', 'painel\dashboard\Dashboard::editarFatura/$1'); // Formulário de edição
    $routes->post('faturas/salvar', 'painel\dashboard\Dashboard::salvarFatura'); // Ação de salvar
    $routes->get('faturas/excluir/(:num)', 'painel\dashboard\Dashboard::excluirFatura/$1'); // Ação de excluir


    // Rotas de Perfil e Faturas 
    $routes->get('perfil', 'painel\dashboard\Dashboard::perfil');
    $routes->get('faturas', 'painel\dashboard\Dashboard::faturas');
});