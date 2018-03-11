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

$router->get('/cart/{server}', 'Frontend\Shop\CartController@render');
$router->put('/cart', 'Frontend\Shop\CartController@put');
$router->delete('/cart', 'Frontend\Shop\CartController@remove');

$router->get('/news/load', 'Frontend\News\NewsController@load');
$router->get('/news/{news}', 'Frontend\News\NewsController@render');
$router->get('/page/{url}', 'Frontend\PageController@render');

//Profile
$router->get('/profile/character', 'Frontend\Profile\CharacterController@render');
$router->post('/profile/character/skin/upload', 'Frontend\Profile\CharacterController@uploadSkin');
$router->post('/profile/character/skin/delete', 'Frontend\Profile\CharacterController@deleteSkin');
$router->post('/profile/character/cloak/upload', 'Frontend\Profile\CharacterController@uploadCloak');
$router->post('/profile/character/cloak/delete', 'Frontend\Profile\CharacterController@deleteCloak');

$router->post('/profile/settings/password', 'Frontend\Profile\SettingsController@password');
$router->post('/profile/settings/sessions/reset', 'Frontend\Profile\SettingsController@resetSessions');

// Admin
$router->get('/admin/control/basic', 'Admin\Control\BasicController@render');
$router->get('/admin/products/add', 'Admin\Products\AddController@render');
$router->post('/admin/products/add', 'Admin\Products\AddController@add');
$router->get('/admin/products/edit/{product}', 'Admin\Products\EditController@render');
$router->post('/admin/products/edit/{product}', 'Admin\Products\EditController@edit');
$router->post('/admin/products/list', 'Admin\Products\ListController@pagination');
$router->delete('/admin/products', 'Admin\Products\ListController@delete');
$router->get('/admin/items/add', 'Admin\Items\AddController@render');
$router->post('/admin/items/add', 'Admin\Items\AddController@add')
    ->name('admin.items.add');
$router->get('/admin/items/edit/{item}', 'Admin\Items\EditController@render');
$router->post('/admin/items/edit/{item}', 'Admin\Items\EditController@edit')
    ->name('admin.items.edit');
$router->delete('/admin/items', 'Admin\Items\ListController@delete');
$router->post('/admin/items/list', 'Admin\Items\ListController@pagination');
$router->post('/admin/users/list', 'Admin\Users\ListController@pagination');
$router->post('/admin/news/list', 'Admin\News\ListController@pagination');
$router->post('/admin/pages/add', 'Admin\Pages\AddController@add');
$router->get('/admin/pages/edit/{page}', 'Admin\Pages\EditController@render');
$router->post('/admin/pages/edit/{page}', 'Admin\Pages\EditController@edit');
$router->post('/admin/pages/list', 'Admin\Pages\ListController@pagination');
$router->delete('/admin/pages', 'Admin\Pages\ListController@delete');
$router->get('/admin/statistic/show', 'App\Handlers\Admin\Statistic\ShowController@render');
$router->get('/admin/information/about', 'Admin\Information\AboutController@render');


$router->any('/skin/front/{username}', 'Api\User\SkinController@front')
    ->name('api.skin.front');
$router->any('/skin/back/{username}', 'Api\User\SkinController@back')
    ->name('api.skin.back');
$router->any('/cloak/front/{username}', 'Api\User\CloakController@front')
    ->name('api.cloak.front');
$router->any('/cloak/back/{username}', 'Api\User\CloakController@back')
    ->name('api.cloak.back');
