<?php

$routes->post('login/auth', 'login\Login::auth');
$routes->get('logout', 'login\Login::logout');