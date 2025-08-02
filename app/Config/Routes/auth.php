<?php


$routes->post('login/auth', 'auth\login\Login::auth');


$routes->get('logout', 'auth\login\Login::logout');