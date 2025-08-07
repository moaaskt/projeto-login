<?php

// Rotas exclusivas para o cliente logado
$routes->group('portal', ['namespace' => 'App\Controllers\Portal', 'filter' => 'auth'], static function ($routes) {
    
    // A rota principal do portal agora aponta para o controller de faturas.
    $routes->get('', 'FaturasController::index'); 
    
    // --- ROTAS DE FATURAS DO CLIENTE ---
    $routes->get('faturas', 'FaturasController::index'); // Esta linha pode ser até redundante agora, mas não causa problema.
    $routes->get('faturas/visualizar/(:num)', 'FaturasController::visualizar/$1');
    $routes->get('faturas/pagar/(:num)', 'FaturasController::pagar/$1');

});