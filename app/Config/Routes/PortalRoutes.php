<?php

/*
 * =================================================================----
 * ROTEAMENTO DA ÁREA DO CLIENTE (VERSÃO CORRIGIDA E UNIFICADA)
 * =================================================================----
 * Usaremos apenas o prefixo /cliente para todas as rotas.
 * O namespace aponta para a pasta de controllers do cliente.
 */
$routes->group('cliente', ['namespace' => 'App\Controllers\Cliente', 'filter' => 'auth'], static function ($routes) {

    // A rota principal do portal do cliente será a nova Dashboard
    $routes->get('/', 'DashboardController::dashboard');
    $routes->get('dashboard', 'DashboardController::dashboard');

    // As rotas de faturas e perfil agora são chamadas pelo DashboardController
    // que centraliza a lógica de exibição das páginas do cliente.
    $routes->get('faturas', 'DashboardController::faturas');
    $routes->get('perfil', 'DashboardController::perfil');
    $routes->get('faturas/visualizar/(:num)', 'DashboardController::visualizar/$1');
    $routes->get('faturas/pagar/(:num)', 'DashboardController::pagar/$1');


    // Se você tiver um FaturasController específico para ações, ele seria chamado aqui:
    // Ex: $routes->get('faturas/visualizar/(:num)', 'FaturasController::visualizar/$1');
});
