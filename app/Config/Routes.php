<?php

namespace Config;

$routes = Services::routes();

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

$routes->get('/', 'login\Login::index');

if (is_file(APPPATH . 'Config/Routes/Auth.php')) {
    require APPPATH . 'Config/Routes/Auth.php';
}

if (is_file(APPPATH . 'Config/Routes/DashboardRoutes.php')) {
    require APPPATH . 'Config/Routes/DashboardRoutes.php';
}