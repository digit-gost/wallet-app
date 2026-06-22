<?php

$router->get('/', 'WalletController@index');

$router->post('/wallet/create', 'WalletController@create');
$router->post('/wallet/depot', 'WalletController@depot');
$router->post('/wallet/retrait', 'WalletController@retrait');
$router->get('/login', 'AuthController@loginForm');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

//$router->get('/', 'WalletController@index');