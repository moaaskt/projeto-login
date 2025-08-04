<?php

$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
    // Rota principal do painel
    $routes->get('', 'painel\dashboard\Dashboard::index');

    // --- ROTAS DE CLIENTES (APONTAM PARA O CONTROLLER DEDICADO) ---
    $routes->get('clientes', 'painel\ClientesController::index');
    $routes->get('clientes/novo', 'painel\ClientesController::novo');
    $routes->get('clientes/editar/(:num)', 'painel\ClientesController::editar/$1');
    $routes->post('clientes/salvar', 'painel\ClientesController::salvar');
    $routes->get('clientes/excluir/(:num)', 'painel\ClientesController::excluir/$1');

    // --- ROTAS DE FATURAS (APONTAM PARA O CONTROLLER PRINCIPAL) ---
    $routes->get('faturas', 'painel\dashboard\Dashboard::faturas');
    $routes->get('faturas/nova', 'painel\dashboard\Dashboard::novaFatura');
    $routes->get('faturas/editar/(:num)', 'painel\dashboard\Dashboard::editarFatura/$1');
    $routes->post('faturas/salvar', 'painel\dashboard\Dashboard::salvarFatura');
    $routes->get('faturas/excluir/(:num)', 'painel\dashboard\Dashboard::excluirFatura/$1');

    // Rota de Perfil
    $routes->get('perfil', 'painel\dashboard\Dashboard::perfil');
});