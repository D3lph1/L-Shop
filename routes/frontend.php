<?php

/** @var \Illuminate\Routing\Router $router */
$router->get('/', 'IndexController@index')
    ->name('frontend.index');

$router->get('/js/lang.min.js', 'LangController@js')
    ->name('frontend.lang.js');

$router->get('/login', 'Auth\LoginController@render')
    ->name('frontend.auth.login.render')
    ->middleware('guest');
$router->post('/login', 'Auth\LoginController@handle')
    ->name('frontend.auth.login.handle')
    ->middleware('guest');

$router->any('/logout', 'Auth\LogoutController@handle')->name('frontend.auth.logout');

$router->get('/register', 'Auth\RegisterController@render')
    ->name('frontend.auth.register.render')
    ->middleware('guest');
$router->post('/register', 'Auth\RegisterController@handle')
    ->name('frontend.auth.register.handle')
    ->middleware(['guest', 'captcha']);

$router->get('/activation/sent', 'Auth\ActivationController@sent')
    ->name('frontend.auth.activation.sent')
    ->middleware('guest');
$router->post('/activation/repeat', 'Auth\ActivationController@repeat')
    ->name('frontend.auth.activation.repeat')
    ->middleware(['guest', 'captcha']);
$router->get('/activation/complete/{code}', 'Auth\ActivationController@complete')
    ->name('frontend.auth.activation.complete');

$router->get('/password/forgot', 'Auth\ForgotPasswordController@render')
    ->name('frontend.auth.password.forgot.render');
$router->post('/password/forgot', 'Auth\ForgotPasswordController@handle')
    ->name('frontend.auth.password.forgot.handle')
    ->middleware(['guest', 'captcha']);
$router->get('/password/reset/{code}', 'Auth\ResetPasswordController@render')
    ->name('frontend.auth.password.reset.render');
$router->post('/password/reset/{code}', 'Auth\ResetPasswordController@handle')
    ->name('frontend.auth.password.reset.handle');

$router->get('/servers', 'Auth\ServersController@render')
    ->name('frontend.servers');

$router->get('/catalog/{server}/{category?}', 'Shop\CatalogController@render')
    ->name('frontend.catalog.render');

$router->get('/cart/{server}', 'Shop\CartController@render')
    ->name('frontend.cart.render');


$router->put('/cart', 'Shop\CartController@put')
    ->name('frontend.cart.put');
$router->delete('/cart', 'Shop\CartController@remove')
    ->name('frontend.cart.remove');
