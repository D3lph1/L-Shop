<?php

/** @var \Illuminate\Routing\Router $router */
$router->any('/auth/login', 'Api\Auth\LoginController@login');
$router->any('/auth/register', 'Api\Auth\RegisterController@register');
$router->any('/auth/launcher/sashok724v3', 'Api\Auth\Sashok724sV3LauncherController@authenticate');
