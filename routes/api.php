<?php

/** @var \Illuminate\Routing\Router $router */

use App\Services\Auth\Permissions;
use function App\permission_middleware;

$router->get('js/lang.min.js', 'LangController@js')
    ->name('frontend.lang.js');

$router->get('/login', 'Frontend\Auth\LoginController@render')
    ->middleware('guest')
    ->name('frontend.auth.login.render');
$router->post('/login', 'Frontend\Auth\LoginController@handle')
    ->middleware('guest')
    ->name('frontend.auth.login.handle');
$router->any('/logout', 'Frontend\Auth\LogoutController@handle')
    ->middleware('auth')
    ->name('frontend.auth.logout');
$router->get('/register', 'Frontend\Auth\RegisterController@render')
    ->middleware('guest')
    ->name('frontend.auth.register.render');
$router->post('/register', 'Frontend\Auth\RegisterController@handle')
    ->middleware('guest')
    ->name('frontend.auth.register.handle');
$router->get('/activation/sent', 'Frontend\Auth\ActivationController@sent')
    ->middleware('guest')
    ->name('frontend.auth.activation.sent');
$router->post('/activation/repeat', 'Frontend\Auth\ActivationController@repeat')
    ->middleware('guest');
$router->get('/activation/complete/{code}', 'Frontend\Auth\ActivationController@complete')
    ->middleware('guest')
    ->name('frontend.auth.activation.complete');
$router->get('/password/forgot', 'Frontend\Auth\ForgotPasswordController@render')
    ->middleware('guest');
$router->post('/password/forgot', 'Frontend\Auth\ForgotPasswordController@handle')
    ->middleware('guest')
    ->name('frontend.auth.password.forgot.handle');
$router->get('/password/reset/{code}', 'Frontend\Auth\ResetPasswordController@render');
$router->post('/password/reset/{code}', 'Frontend\Auth\ResetPasswordController@handle')
    ->name('frontend.auth.password.reset.handle');
$router->get('/servers', 'Frontend\Auth\ServersController@render');

// Shop
$router->get('/shop', 'Frontend\Shop\ShopController@render');
$router->get('/catalog/{server}/{category?}', 'Frontend\Shop\CatalogController@render');
$router->get('/news/load', 'Frontend\Shop\NewsController@load');

$router->get('/cart/{server}', 'Frontend\Shop\CartController@render');
$router->put('/cart', 'Frontend\Shop\CartController@put');
$router->delete('/cart', 'Frontend\Shop\CartController@remove');


// Admin
$router->get('/admin/control/basic', 'Admin\Control\BasicController@render');
$router->post('/admin/products/list', 'Admin\Products\ListController@pagination');
$router->post('/admin/items/list', 'Admin\Items\ListController@pagination');
$router->post('/admin/users/list', 'Admin\Users\ListController@pagination');
$router->post('/admin/news/list', 'Admin\News\ListController@pagination');
$router->post('/admin/pages/list', 'Admin\Pages\ListController@pagination');
$router->get('/admin/information/about', 'Admin\Information\AboutController@render');
