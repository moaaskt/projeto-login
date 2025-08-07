<?php

$routes->group('dashboard', ['filter' => 'admin'], function ($routes) {
    // Rota principal do painel
    $routes->get('', 'painel\dashboard\Dashboard::index');

// Rotas de verificação AJAX
 $routes->post('clientes/check-cpf-cnpj', 'painel\ClientesController::checkCpfCnpj');




    // --- ROTAS DE CLIENTES ---
    $routes->get('clientes', 'painel\ClientesController::index');
    $routes->get('clientes/novo', 'painel\ClientesController::novo');
    $routes->get('clientes/visualizar/(:num)', 'painel\ClientesController::visualizar/$1');
    $routes->get('clientes/pdf/(:num)', 'painel\ClientesController::gerarPdf/$1');
    $routes->get('clientes/modelo-excel', 'painel\ClientesController::gerarModeloExcel');
    $routes->get('clientes/editar/(:num)', 'painel\ClientesController::editar/$1');
    $routes->post('clientes/importar', 'painel\ClientesController::importar');
    $routes->post('clientes/salvar', 'painel\ClientesController::salvar');
    $routes->get('clientes/excluir/(:num)', 'painel\ClientesController::excluir/$1');
    $routes->post('clientes/check-email', 'painel\ClientesController::checkEmail');
    $routes->get('clientes/excluir/(:num)', 'painel\ClientesController::excluir/$1');

    

    // --- ROTAS DE FATURAS ---
    $routes->get('faturas', 'painel\FaturasController::index');
    $routes->get('faturas/nova', 'painel\FaturasController::nova');
    $routes->get('faturas/visualizar/(:num)', 'painel\FaturasController::visualizar/$1');
    $routes->get('faturas/excel/(:num)', 'painel\FaturasController::gerarExcel/$1');
    $routes->get('faturas/editar/(:num)', 'painel\FaturasController::editar/$1');
    $routes->post('faturas/salvar', 'painel\FaturasController::salvar');
    $routes->get('faturas/excluir/(:num)', 'painel\FaturasController::excluir/$1');

    // --- ROTAS DE PERFIL (CORRIGIDAS) ---
    $routes->get('perfil', 'painel\PerfilController::index');
    $routes->post('perfil/atualizar-dados', 'painel\PerfilController::atualizarDados');
    $routes->post('perfil/alterar-senha', 'painel\PerfilController::alterarSenha');
});
