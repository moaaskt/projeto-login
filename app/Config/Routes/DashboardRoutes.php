<?php

$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'painel\dashboard\Dashboard::index');
    $routes->get('perfil', 'painel\dashboard\Dashboard::perfil');
    $routes->get('faturas', 'painel\dashboard\Dashboard::faturas');
    $routes->get('clientes', 'painel\dashboard\Dashboard::clientes');
});