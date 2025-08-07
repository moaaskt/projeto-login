<?php

// Rotas exclusivas para o cliente logado
$routes->group('portal', ['filter' => 'cliente'], function ($routes) {
    // AINDA VAMOS CRIAR ESTE CONTROLLER
    $routes->get('', 'Portal\DashboardController::index'); 
    
    // --- ROTAS DE FATURAS DO CLIENTE ---
    // AINDA VAMOS CRIAR ESTE CONTROLLER
    $routes->get('faturas', 'Portal\FaturasController::index');
    $routes->get('faturas/visualizar/(:num)', 'Portal\FaturasController::visualizar/$1');
    $routes->get('faturas/pagar/(:num)', 'Portal\FaturasController::pagar/$1');
});