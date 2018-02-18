<?php

/** @var \Illuminate\Routing\Router $router */
$router->get('js/lang.min.js', 'LangController@js')
    ->name('frontend.lang.js');

$router->get('/login', 'Frontend\Auth\LoginController@render')
    ->middleware('guest');
$router->any('/logout', 'Frontend\Auth\LogoutController@handle')
    ->middleware('auth')
    ->name('frontend.auth.logout');
$router->post('/login', 'Frontend\Auth\LoginController@handle')
    ->middleware('guest');
$router->get('/register', 'Frontend\Auth\RegisterController@render')
    ->middleware('guest');
$router->post('/register', 'Frontend\Auth\RegisterController@handle')
    ->middleware('guest');
$router->get('/activation/sent', 'Frontend\Auth\ActivationController@sent')
    ->middleware('guest');
$router->post('/activation/repeat', 'Frontend\Auth\ActivationController@repeat')
    ->middleware('guest');
$router->get('/activation/complete/{code}', 'Frontend\Auth\ActivationController@complete')
    ->middleware('guest')
    ->name('frontend.auth.activation.complete');
$router->get('/password/forgot', 'Frontend\Auth\ForgotPasswordController@render')
    ->middleware('guest');
$router->post('/password/forgot', 'Frontend\Auth\ForgotPasswordController@handle')
    ->middleware('guest');
$router->get('/password/reset/{code}', 'Frontend\Auth\ResetPasswordController@render');
$router->post('/password/reset/{code}', 'Frontend\Auth\ResetPasswordController@handle')
    ->name('frontend.auth.password.reset');
$router->get('/servers', 'Frontend\Auth\ServersController@render');

// Shop
$router->get('/shop', 'Frontend\Shop\ShopController@render');
$router->get('/catalog/{server}/{category?}', 'Frontend\Shop\CatalogController@render');
$router->get('/news/load', 'Frontend\Shop\NewsController@load');
