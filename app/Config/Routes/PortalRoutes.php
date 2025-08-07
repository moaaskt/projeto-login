<?php
// Rotas do Portal do Cliente, protegidas pelo filtro 'cliente'
$routes->group('portal', ['filter' => 'cliente'], function ($routes) {
    $routes->get('', 'painel\PortalController::index'); // Dashboard do cliente
    $routes->get('faturas', 'painel\PortalController::faturas'); // Lista de faturas do cliente
    $routes->get('perfil', 'painel\PerfilController::index'); // Reutilizamos o PerfilController
});