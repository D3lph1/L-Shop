<?php

/** @var \Illuminate\Routing\Router $router */

$router->get('js/lang.min.js', 'LangController@js')
    ->name('frontend.lang.js');

$router->get('/login', 'Frontend\Auth\LoginController@render')
    ->name('frontend.auth.login.render');
$router->post('/login', 'Frontend\Auth\LoginController@handle')
    ->name('frontend.auth.login.handle');
$router->any('/logout', 'Frontend\Auth\LogoutController@handle')
    ->name('frontend.auth.logout');
$router->get('/register', 'Frontend\Auth\RegisterController@render')
    ->name('frontend.auth.register.render');
$router->post('/register', 'Frontend\Auth\RegisterController@handle')
    ->name('frontend.auth.register.handle');
$router->get('/activation/sent', 'Frontend\Auth\ActivationController@sent')
    ->name('frontend.auth.activation.sent');
$router->post('/activation/repeat', 'Frontend\Auth\ActivationController@repeat');
$router->get('/activation/complete/{code}', 'Frontend\Auth\ActivationController@complete')
    ->name('frontend.auth.activation.complete');
$router->get('/password/forgot', 'Frontend\Auth\ForgotPasswordController@render');
$router->post('/password/forgot', 'Frontend\Auth\ForgotPasswordController@handle')
    ->name('frontend.auth.password.forgot.handle');
$router->get('/password/reset/{code}', 'Frontend\Auth\ResetPasswordController@render');
$router->post('/password/reset/{code}', 'Frontend\Auth\ResetPasswordController@handle')
    ->name('frontend.auth.password.reset.handle');
$router->get('/servers', 'Frontend\Auth\SelectServerController@render');

// Shop
$router->get('/shop', 'Frontend\Shop\ShopController@render');
$router->get('/catalog/{server}/{category?}', 'Frontend\Shop\CatalogController@render')
    ->where('server', '[0-9]+');
$router->post('/catalog/purchase', 'Frontend\Shop\CatalogController@purchase');

$router->get('/payment/{purchase}', 'Frontend\Shop\PaymentMethodsController@render')
    ->where('purchase', '[0-9]+');

$router->post('/replenishment', 'Frontend\Shop\ReplenishmentController@handle');

$router->get('/monitoring', 'Frontend\MonitoringController@monitor');

$router->get('/cart/{server}', 'Frontend\Shop\CartController@render')
    ->where('server', '[0-9]+');
$router->put('/cart', 'Frontend\Shop\CartController@put');
$router->delete('/cart', 'Frontend\Shop\CartController@remove');
$router->post('/cart/{server}', 'Frontend\Shop\CartController@purchase')
    ->where('server', '[0-9]+');

$router->get('/news/load', 'Frontend\News\NewsController@load');
$router->get('/news/{news}', 'Frontend\News\NewsController@render');
$router->get('/page/{url}', 'Frontend\PageController@render');

// Profile
$router->get('/profile/character', 'Frontend\Profile\CharacterController@render');
$router->post('/profile/character/skin/upload', 'Frontend\Profile\CharacterController@uploadSkin');
$router->post('/profile/character/skin/delete', 'Frontend\Profile\CharacterController@deleteSkin');
$router->post('/profile/character/cloak/upload', 'Frontend\Profile\CharacterController@uploadCloak');
$router->post('/profile/character/cloak/delete', 'Frontend\Profile\CharacterController@deleteCloak');

$router->get('/profile/settings', 'Frontend\Profile\SettingsController@render');
$router->post('/profile/settings/password', 'Frontend\Profile\SettingsController@password');
$router->post('/profile/settings/sessions/reset', 'Frontend\Profile\SettingsController@resetSessions');

$router->post('/profile/purchases', 'Frontend\Profile\PurchasesController@pagination');
$router->post('/profile/cart', 'Frontend\Profile\CartController@pagination');
$router->post('/profile/cart/distribute/{distribution}', 'Frontend\Profile\CartController@distribute')
    ->where('distribution', '[0-9]+');

// Admin
$router->get('/admin/control/basic', 'Admin\Control\BasicController@render');
$router->post('/admin/control/basic', 'Admin\Control\BasicController@save');
$router->get('/admin/control/payments', 'Admin\Control\PaymentsController@render');
$router->post('/admin/control/payments', 'Admin\Control\PaymentsController@save');
$router->get('/admin/control/api', 'Admin\Control\ApiController@render');
$router->post('/admin/control/api', 'Admin\Control\ApiController@save');
$router->get('/admin/control/security', 'Admin\Control\SecurityController@render');
$router->post('/admin/control/security', 'Admin\Control\SecurityController@save');
$router->get('/admin/control/optimization', 'Admin\Control\OptimizationController@render');
$router->post('/admin/control/optimization', 'Admin\Control\OptimizationController@save');

$router->post('/admin/servers/enable/{server}', 'Admin\Servers\SwitchController@enable')
    ->where('server', '[0-9]+');
$router->post('/admin/servers/disable/{server}', 'Admin\Servers\SwitchController@disable')
    ->where('server', '[0-9]+');

$router->get('/admin/products/add', 'Admin\Products\AddController@render');
$router->post('/admin/products/add', 'Admin\Products\AddController@add');
$router->get('/admin/products/edit/{product}', 'Admin\Products\EditController@render')
    ->where('product', '[0-9]+');
$router->post('/admin/products/edit/{product}', 'Admin\Products\EditController@edit')
    ->where('product', '[0-9]+');
$router->post('/admin/products/list', 'Admin\Products\ListController@pagination');
$router->delete('/admin/products', 'Admin\Products\ListController@delete');

$router->get('/admin/items/add', 'Admin\Items\AddController@render');
$router->post('/admin/items/add', 'Admin\Items\AddController@add')
    ->name('admin.items.add');
$router->get('/admin/items/edit/{item}', 'Admin\Items\EditController@render')
    ->where('item', '[0-9]+');
$router->post('/admin/items/edit/{item}', 'Admin\Items\EditController@edit')
    ->where('item', '[0-9]+')
    ->name('admin.items.edit');
$router->delete('/admin/items', 'Admin\Items\ListController@delete');
$router->post('/admin/items/list', 'Admin\Items\ListController@pagination');

$router->post('/admin/news/list', 'Admin\News\ListController@pagination');

$router->post('/admin/pages/add', 'Admin\Pages\AddController@add');
$router->get('/admin/pages/edit/{page}', 'Admin\Pages\EditController@render')
    ->where('page', '[0-9]+');
$router->post('/admin/pages/edit/{page}', 'Admin\Pages\EditController@edit')
    ->where('page', '[0-9]+');
$router->post('/admin/pages/list', 'Admin\Pages\ListController@pagination');
$router->delete('/admin/pages', 'Admin\Pages\ListController@delete');

$router->get('/admin/users/edit/{user}', 'Admin\Users\EditController@render')
    ->where('user', '[0-9]+');
$router->post('/admin/users/edit/{user}', 'Admin\Users\EditController@edit')
    ->where('user', '[0-9]+');
$router->post('/admin/users/edit/{user}/skin', 'Admin\Users\EditController@uploadSkin')
    ->where('user', '[0-9]+');
$router->post('/admin/users/edit/{user}/cloak', 'Admin\Users\EditController@uploadCloak')
    ->where('user', '[0-9]+');
$router->delete('/admin/users/edit/{user}/skin', 'Admin\Users\EditController@deleteSkin')
    ->where('user', '[0-9]+');
$router->delete('/admin/users/edit/{user}/cloak', 'Admin\Users\EditController@deleteCloak')
    ->where('user', '[0-9]+');
$router->delete('/admin/users/edit/ban/{ban}', 'Admin\Users\EditController@deleteBan');
$router->post('/admin/users/edit/{user}/ban', 'Admin\Users\EditController@addBan')
    ->where('user', '[0-9]+');
$router->post('/admin/users/edit/{user}', 'Admin\Users\EditController@edit')
    ->where('user', '[0-9]+');
$router->post('/admin/users/list', 'Admin\Users\ListController@pagination');
$router->delete('/admin/users', 'Admin\Users\ListController@delete');

$router->get('/admin/other/debug', 'Admin\Other\DebugController@render');
$router->post('/admin/other/debug/send', 'Admin\Other\DebugController@sendEmail');
$router->get('/admin/other/rcon', 'Admin\Other\RconController@render');

$router->get('/admin/statistic/show', 'Admin\Statistic\ShowController@render');
$router->post('/admin/statistic/show/profit/month', 'Admin\Statistic\ShowController@profitForMonth');
$router->post('/admin/statistic/show/purchases/month', 'Admin\Statistic\ShowController@purchasesForMonth');
$router->post('/admin/statistic/show/registered/month', 'Admin\Statistic\ShowController@registeredForMonth');
$router->post('/admin/statistic/purchases', 'Admin\Statistic\PurchasesController@pagination');
$router->post('/admin/statistic/purchases/complete/{purchase}', 'Admin\Statistic\PurchasesController@complete')
    ->where('purchase', '[0-9]+');

$router->get('/admin/information/about', 'Admin\Information\AboutController@render');

$router->any('/skin/front/{username}', 'Frontend\Character\SkinController@front')
    ->name('api.skin.front');
$router->any('/skin/back/{username}', 'Frontend\Character\SkinController@back')
    ->name('api.skin.back');
$router->any('/cloak/front/{username}', 'Frontend\Character\CloakController@front')
    ->name('api.cloak.front');
$router->any('/cloak/back/{username}', 'Frontend\Character\CloakController@back')
    ->name('api.cloak.back');
