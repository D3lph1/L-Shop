<?php

/**
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 */

Route::group(['namespace' => 'Auth'], function () {
    // Render sign in page
    Route::get('/signin', 'SignInController@render')
        ->name('signin')
        ->middleware('auth:guest');

    // Authorize user by POST-request
    Route::post('/signin', 'SignInController@signin')
        ->name('signin.post')
        ->middleware('auth:guest');

    // Logout user
    Route::get('/logout', 'SignInController@logout')
        ->name('logout')
        ->middleware('auth:hard');

    // Render sign up page
    Route::get('/signup', 'SignUpController@render');

    // Register user
    Route::post('/signup', 'SignUpController@signup');

    // Render select server page
    Route::get('/servers', 'SelectServerController@render')
        ->name('servers')
        ->middleware('servers:all');
});

Route::group(['namespace' => 'Shop', 'where' => ['server' => '\d+']], function () {
    // Route of main shop page
    Route::get('/server/{server}/{category?}', 'CatalogController@render')
        ->name('catalog')
        ->where([
            'category' => '\d+'
        ])
        ->middleware([
            'servers:all',
            'auth:soft'
        ]);

    Route::get('/server/{server}/cart', 'CartController@render')
        ->name('cart')
        ->middleware([
            'servers:all',
            'auth:soft'
        ]);

    Route::post('/server/{server}/cart', 'CartController@buy')
        ->name('cart.buy')
        ->middleware([
            'servers:one',
            'auth:soft',
            'captcha'
        ]);

    Route::post('/server/{server}/buy/{product}', 'CatalogController@buy')
        ->name('catalog.buy')
        ->middleware([
            'servers:one',
            'auth:soft',
            'captcha',
        ]);

    Route::post('/server/{server}/cart/put/{product}', 'CartController@put')
        ->name('cart.put')
        ->where([
            'product' => '\d+'
        ])
        ->middleware('servers:one');

    Route::post('/server/{server}/cart/remove/{product}', 'CartController@remove')
        ->name('cart.remove')
        ->where([
            'product' => '\d+'
        ])
        ->middleware('servers:one');
});

Route::group(['namespace' => 'Payment'], function () {
    Route::get('/server/{server}/pay/{payment}', 'PaymentController@render')
        ->name('payment.methods')
        ->middleware([
            'servers:all',
        ]);

    Route::get('/server/{server}/fillupbalance', 'PaymentController@renderFillUpBalancePage')
        ->name('fillupbalance')
        ->middleware([
            'servers:all',
            'auth:hard'
        ]);

    Route::post('/server/{server}/fillupbalance', 'PaymentController@fillUpBalance')
        ->name('payment.fillupbalance')
        ->middleware([
            'servers:one',
            'auth:hard',
            'captcha'
        ]);


    Route::any('/payment/result/robokassa', 'ResultController@robokassa');
    Route::any('/payment/success/robokassa', 'SuccessController@robokassa');
    Route::any('/payment/error/robokassa', 'ErrorController@robokassa');
});

Route::group(['namespace' => 'Profile', 'where' => ['server' => '\d+']], function () {
    Route::get('/server/{server}/profile/payments', 'PaymentsController@render')
        ->name('profile.payments')
        ->middleware([
            'servers:all',
            'auth:hard'
        ]);

    Route::post('/server/{server}/profile/payments/{payment}', 'PaymentsController@info')
        ->name('profile.payments.info')
        ->middleware([
            'servers:one',
            'auth:hard'
        ]);

    Route::get('/server/{server}/profile/cart', 'CartController@render')
        ->name('profile.cart')
        ->where('payment', '\d+')
        ->middleware([
            'servers:all',
            'auth:hard'
        ]);
});

Route::group(['namespace' => 'Api'], function () {
    Route::get('/api/signin', 'SignInController@signin')
        ->name('api.signin');
});

/**
 * Admin section
 */
Route::group(['namespace' => 'Admin', 'where' => ['server' => '\d+'], 'middleware' => ['auth:admin']], function () {
    // Render main settings page
    Route::get('/server/{server}/admin/control/main_settings', 'Control\MainSettingsController@render')
        ->name('admin.control.main_settings')
        ->middleware([
            'servers:all'
        ]);

    // Save main settings
    Route::post('/server/{server}/admin/control/main_settings', 'Control\MainSettingsController@save')
        ->name('admin.control.main_settings.save')
        ->middleware([
            'servers:all'
        ]);

    // Render security settings page
    Route::get('/server/{server}/admin/control/security', 'Control\SecurityController@render')
        ->name('admin.control.security')
        ->middleware([
            'servers:all'
        ]);

    // Save security settings
    Route::post('/server/{server}/admin/control/security', 'Control\SecurityController@save')
        ->name('admin.control.security.save')
        ->middleware([
            'servers:all'
        ]);

    // Render optimization settings page
    Route::get('/server/{server}/admin/control/optimization', 'Control\OptimizationController@render')
        ->name('admin.control.optimization')
        ->middleware([
            'servers:all'
        ]);

    // Update routes cache
    Route::post('/server/{server}/admin/control/optimization/update_routes_cache', 'Control\OptimizationController@updateRoutesCache')
        ->name('admin.control.optimization.update_routes_cache')
        ->middleware([
            'servers:all'
        ]);

    // Update config cache
    Route::post('/server/{server}/admin/control/optimization/update_config_cache', 'Control\OptimizationController@updateConfigCache')
        ->name('admin.control.optimization.update_config_cache')
        ->middleware([
            'servers:all'
        ]);

    // Update view cache
    Route::post('/server/{server}/admin/control/optimization/clear_view_cache', 'Control\OptimizationController@clearViewCache')
        ->name('admin.control.optimization.clear_view_cache')
        ->middleware([
            'servers:all'
        ]);

    Route::get('/server/{server}/admin/servers/add', 'Servers\AddController@render')
        ->name('admin.servers.add')
        ->middleware([
            'servers:all'
        ]);

    Route::get('/server/{server}/admin/servers/list', 'Servers\EditController@renderList')
        ->name('admin.servers.list')
        ->middleware([
            'servers:all'
        ]);

    Route::get('/server/{server}/admin/servers/edit/{edit}', 'Servers\EditController@renderEdit')
        ->name('admin.servers.edit')
        ->middleware([
            'servers:all'
        ]);

    // Enable given server
    Route::post('/server/{server}/admin/servers/enable/{enable}', 'Servers\EditController@enable')
        ->name('admin.servers.enable')
        ->middleware([
            'servers:all'
        ]);

    // Disable given server
    Route::post('/server/{server}/admin/servers/disable/{disable}', 'Servers\EditController@disable')
        ->name('admin.servers.disable')
        ->middleware([
            'servers:all'
        ]);

    // Render about page
    Route::get('/server/{server}/admin/info/about', 'Info\AboutController@render')
        ->name('admin.info.about')
        ->middleware([
            'servers:all'
        ]);
});

Route::get('/server/{server}/test', 'TestController@test')
    ->middleware('servers:one');
