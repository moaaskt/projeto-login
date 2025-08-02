<?php

$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
    // Rota principal do painel
    $routes->get('', 'painel\dashboard\Dashboard::index');

    // Rotas de Clientes (CRUD Completo)
    $routes->get('clientes', 'painel\dashboard\Dashboard::clientes'); // Listar
    $routes->get('clientes/novo', 'painel\dashboard\Dashboard::novoCliente'); // Formulário de novo
    $routes->get('clientes/editar/(:num)', 'painel\dashboard\Dashboard::editarCliente/$1'); // Formulário de edição
    $routes->post('clientes/salvar', 'painel\dashboard\Dashboard::salvarCliente'); // Ação de salvar (novo ou edição)
    $routes->get('clientes/excluir/(:num)', 'painel\dashboard\Dashboard::excluirCliente/$1'); // Ação de excluir

    // Rotas de Perfil e Faturas (já existentes)
    $routes->get('perfil', 'painel\dashboard\Dashboard::perfil');
    $routes->get('faturas', 'painel\dashboard\Dashboard::faturas');
});