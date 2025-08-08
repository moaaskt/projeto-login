<?php


// Rota para MOSTRAR o formulário de cadastro
$routes->get('cadastro', 'auth\cadastro\Cadastro::index');

// Rota para PROCESSAR os dados do formulário de cadastro
$routes->post('cadastro/salvar', 'auth\cadastro\Cadastro::store');


// Rotas para o fluxo de "Esqueci minha senha"
$routes->get('forgot-password', 'auth\login\Login::forgotPassword');
$routes->post('send-reset-link', 'auth\login\Login::sendResetLink');
$routes->get('reset-password/(:hash)', 'auth\login\Login::resetPassword/$1');
$routes->post('update-password', 'auth\login\Login::updatePassword');


$routes->post('login/auth', 'auth\login\Login::auth');
$routes->get('logout', 'auth\login\Login::logout');