<?php

/**
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 */

Route::get('/', 'IndexController@index')->name('index');

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
    Route::get('/signup', 'SignUpController@render')->name('signup');

    // Register user
    Route::post('/signup', 'SignUpController@signup')
        ->name('signup.handle')
        ->middleware([
            'auth:guest',
            'captcha'
        ]);

    // Render wait activate user page
    Route::get('/activate', 'ActivationController@renderWaitPage')
        ->name('activation.wait')
        ->middleware('auth:guest');

    // Repeat sending activation mail
    Route::post('/activate', 'ActivationController@repeatSend')
        ->name('activation.repeat_send')
        ->middleware([
            'auth:guest',
            'captcha'
        ]);

    // Activate given user
    Route::get('/activate/{user}/{code}', 'ActivationController@activate')->name('activate');

    // Render forgot password page
    Route::get('/forgot', 'ForgotPasswordController@render')
        ->name('forgot')
        ->middleware('auth:guest');

    // Handle forgot password request
    Route::post('/forgot', 'ForgotPasswordController@handle')
        ->name('forgot.handle')
        ->middleware([
            'auth:guest',
            'captcha'
        ]);

    // Render reset password page
    Route::get('/reset_password/{user}/{code}', 'ForgotPasswordController@renderResetPasswordPage')
        ->name('reset_password');

    // Render reset password page
    Route::post('/reset_password/{user}/{code}', 'ForgotPasswordController@resetPassword')
        ->name('reset_password.handle');

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

    Route::get('/server/{server}/page/{page}', 'PageController@render')
        ->name('page')
        ->middleware([
            'servers:all'
        ]);
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

    Route::get('/server/{server}/profile/settings', 'SettingsController@render')
        ->name('profile.settings')
        ->middleware([
            'servers:all',
            'auth:hard'
        ]);

    Route::post('/server/{server}/profile/settings', 'SettingsController@password')
        ->name('profile.settings.password')
        ->middleware([
            'servers:one',
            'auth:hard'
        ]);

    Route::post('/server/{server}/profile/sessions', 'SettingsController@sessions')
        ->name('profile.settings.sessions')
        ->middleware([
            'servers:one',
            'auth:hard'
        ]);
});

Route::group(['namespace' => 'Api'], function () {
    Route::get('/api/signin', 'SignInController@signin')
        ->name('api.signin');

    Route::any('/api/signup', 'SignupController@signup')
        ->name('api.signup');

    Route::any('/api/launcher/sashok/auth', 'SashokLauncher@auth')
        ->name('api.launcher.sashok.auth');
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

    // Render payments agregators page
    Route::get('/server/{server}/admin/control/payments', 'Control\PaymentsController@render')
        ->name('admin.control.payments')
        ->middleware([
            'servers:all'
        ]);

    // Save payments agregators settings
    Route::post('/server/{server}/admin/control/payments', 'Control\PaymentsController@save')
        ->name('admin.control.payments.save')
        ->middleware([
            'servers:all'
        ]);

    // Render api settings page
    Route::get('/server/{server}/admin/control/api', 'Control\ApiController@render')
        ->name('admin.control.api')
        ->middleware([
            'servers:all'
        ]);

    // Save api settings page
    Route::post('/server/{server}/admin/control/api', 'Control\ApiController@save')
        ->name('admin.control.api.save')
        ->middleware([
            'servers:one'
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
            'servers:one'
        ]);

    // Render optimization settings page
    Route::get('/server/{server}/admin/control/optimization', 'Control\OptimizationController@render')
        ->name('admin.control.optimization')
        ->middleware([
            'servers:all'
        ]);

    // Save optimization settings
    Route::post('/server/{server}/admin/control/optimization', 'Control\OptimizationController@save')
        ->name('admin.control.optimization.save')
        ->middleware([
            'servers:one'
        ]);

    // Update routes cache
    Route::get('/server/{server}/admin/control/optimization/update_routes_cache', 'Control\OptimizationController@updateRoutesCache')
        ->name('admin.control.optimization.update_routes_cache')
        ->middleware([
            'servers:one'
        ]);

    // Update config cache
    Route::get('/server/{server}/admin/control/optimization/update_config_cache', 'Control\OptimizationController@updateConfigCache')
        ->name('admin.control.optimization.update_config_cache')
        ->middleware([
            'servers:one'
        ]);

    // Clear view cache
    Route::get('/server/{server}/admin/control/optimization/clear_view_cache', 'Control\OptimizationController@clearViewCache')
        ->name('admin.control.optimization.clear_view_cache')
        ->middleware([
            'servers:one'
        ]);

    // Clear app (L-Shop) cache
    Route::get('/server/{server}/admin/control/optimization/clear_app_cache', 'Control\OptimizationController@clearAppCache')
        ->name('admin.control.optimization.clear_app_cache')
        ->middleware([
            'servers:one'
        ]);

    // Render add new server page
    Route::get('/server/{server}/admin/servers/add', 'Servers\AddController@render')
        ->name('admin.servers.add')
        ->middleware([
            'servers:all'
        ]);

    // Save new server
    Route::post('/server/{server}/admin/servers/add', 'Servers\AddController@save')
        ->name('admin.servers.add.save')
        ->middleware([
            'servers:one'
        ]);

    // Render page with servers list for edit
    Route::get('/server/{server}/admin/servers/list', 'Servers\ListController@render')
        ->name('admin.servers.list')
        ->middleware([
            'servers:all'
        ]);

    // Render edit server page
    Route::get('/server/{server}/admin/servers/edit/{edit}', 'Servers\EditController@render')
        ->name('admin.servers.edit')
        ->middleware([
            'servers:all'
        ]);

    // Add category for given server
    Route::post('/server/{server}/admin/servers/edit/{edit}/add_category', 'Servers\EditController@addCategory')
        ->name('admin.servers.edit.add_category')
        ->middleware([
            'servers:one'
        ]);

    // Add category for given server
    Route::post('/server/{server}/admin/servers/edit/{edit}/remove_category', 'Servers\EditController@removeCategory')
        ->name('admin.servers.edit.remove_category')
        ->middleware([
            'servers:one'
        ]);

    // Save edited server
    Route::post('/server/{server}/admin/servers/edit/{edit}', 'Servers\EditController@save')
        ->name('admin.servers.edit.save')
        ->middleware([
            'servers:one'
        ]);

    // Remove given server
    Route::any('/server/{server}/admin/servers/remove/{remove}', 'Servers\EditController@removeServer')
        ->name('admin.servers.remove')
        ->middleware([
            'servers:all'
        ]);

    // Enable given server
    Route::post('/server/{server}/admin/servers/enable/{enable}', 'Servers\ListController@enable')
        ->name('admin.servers.enable')
        ->middleware([
            'servers:one'
        ]);

    // Disable given server
    Route::post('/server/{server}/admin/servers/disable/{disable}', 'Servers\ListController@disable')
        ->name('admin.servers.disable')
        ->middleware([
            'servers:one'
        ]);

    /**
     * PRODUCTS SECTION
     */
    // Render page with items list for edit
    Route::get('/server/{server}/admin/products/list', 'Products\ListController@render')
        ->name('admin.products.list')
        ->middleware([
            'servers:all'
        ]);

    // Render add new product page
    Route::get('/server/{server}/admin/products/add', 'Products\AddController@render')
        ->name('admin.products.add')
        ->middleware([
            'servers:all'
        ]);

    // Render add new product page
    Route::get('/server/{server}/admin/products/edit/{product}', 'Products\EditController@render')
        ->name('admin.products.edit')
        ->middleware([
            'servers:all'
        ]);

    // Save added product
    Route::post('/server/{server}/admin/products/add', 'Products\AddController@save')
        ->name('admin.products.add.save')
        ->middleware([
            'servers:all'
        ]);

    // Save edited product
    Route::post('/server/{server}/admin/products/edit/{product}', 'Products\EditController@save')
        ->name('admin.products.edit.save')
        ->middleware([
            'servers:one'
        ]);

    // Remove edited product
    Route::any('/server/{server}/admin/products/remove/{product}', 'Products\EditController@remove')
        ->name('admin.products.edit.remove')
        ->middleware([
            'servers:one'
        ]);
    /**
     * END PRODUCTS SECTION
     */

    /**
     * ITEMS SECTION
     */
    // Render page with items list for edit
    Route::get('/server/{server}/admin/items/list', 'Items\ListController@render')
        ->name('admin.items.list')
        ->middleware([
            'servers:all'
        ]);

    // Render edited item item page
    Route::get('/server/{server}/admin/items/edit/{item}', 'Items\EditController@render')
        ->name('admin.items.edit')
        ->middleware([
            'servers:all'
        ]);

    // Save edited item
    Route::post('/server/{server}/admin/items/edit/{item}', 'Items\EditController@save')
        ->name('admin.items.edit.save')
        ->middleware([
            'servers:one'
        ]);

    // Remove edited item
    Route::any('/server/{server}/admin/items/remove/{item}', 'Items\EditController@remove')
        ->name('admin.items.edit.remove')
        ->middleware([
            'servers:one'
        ]);

    // Render add item page
    Route::get('/server/{server}/admin/items/add', 'Items\AddController@render')
        ->name('admin.items.add')
        ->middleware([
            'servers:all'
        ]);

    // Save added item
    Route::post('/server/{server}/admin/items/add', 'Items\AddController@save')
        ->name('admin.items.add.save')
        ->middleware([
            'servers:all'
        ]);
    /**
     * END OF ITEM SECTION
     */

    /**
     * STATIC PAGES SECTION
     */
    // Render add static page page
    Route::get('/server/{server}/admin/pages/add', 'Pages\AddController@render')
        ->name('admin.pages.add')
        ->middleware([
            'servers:all'
        ]);

    // Handle added new static page request
    Route::post('/server/{server}/admin/pages/add', 'Pages\AddController@save')
        ->name('admin.pages.add.save')
        ->middleware([
            'servers:one'
        ]);

    // Render edit static page page
    Route::get('/server/{server}/admin/pages/edit/{id}', 'Pages\EditController@render')
        ->name('admin.pages.edit')
        ->middleware([
            'servers:all'
        ]);

    // Handle edited static page request
    Route::post('/server/{server}/admin/pages/edit/{id}', 'Pages\EditController@save')
        ->name('admin.pages.edit.save')
        ->middleware([
            'servers:one'
        ]);

    // Handle edited static page request
    Route::get('/server/{server}/admin/pages/delete/{id}', 'Pages\EditController@delete')
        ->name('admin.pages.delete')
        ->middleware([
            'servers:one'
        ]);


    // Render add static page page
    Route::get('/server/{server}/admin/pages/list', 'Pages\ListController@render')
        ->name('admin.pages.list')
        ->middleware([
            'servers:all'
        ]);
    /**
     * END STATIC PAGES SECTION
     */


    /**
     * USERS SECTION
     */
    // Render page with users list
    Route::get('/server/{server}/admin/users/list', 'Users\ListController@render')
        ->name('admin.users.list')
        ->middleware([
            'servers:all'
        ]);

    // Render page with users list
    Route::any('/server/{server}/admin/users/complete/{user}', 'Users\ListController@complete')
        ->name('admin.users.complete')
        ->middleware([
            'servers:one'
        ]);

    // Render edit user page
    Route::get('/server/{server}/admin/users/edit/{edit}', 'Users\EditController@render')
        ->name('admin.users.edit')
        ->middleware([
            'servers:all'
        ]);

    // Save edited user
    Route::post('/server/{server}/admin/users/edit/{edit}', 'Users\EditController@save')
        ->name('admin.users.edit.save')
        ->middleware([
            'servers:one'
        ]);

    // Remove given user
    Route::any('/server/{server}/admin/users/remove/{user}', 'Users\EditController@remove')
        ->name('admin.users.edit.remove')
        ->middleware([
            'servers:one'
        ]);

    // Remove given user
    Route::get('/server/{server}/admin/users/destroy_sessions/{user}', 'Users\EditController@destroySessions')
        ->name('admin.users.edit.destroy_sessions')
        ->middleware([
            'servers:one'
        ]);
    /**
     * END USERS SECTION
     */

    /**
     * OTHER SECTION
     */
    Route::get('/server/{server}/admin/other/debug', 'Other\DebugController@render')
        ->name('admin.other.debug')
        ->middleware([
            'servers:all'
        ]);

    Route::post('/server/{server}/admin/other/debug/test_mail', 'Other\DebugController@testMail')
        ->name('admin.other.test_mail')
        ->middleware([
            'servers:one'
        ]);
    /**
     * END OTHER SECTION
     */

    /**
     * STATISTIC SECTION
     */
    Route::get('/server/{server}/admin/statistic/payments', 'Statistic\PaymentsController@render')
        ->name('admin.statistic.payments')
        ->middleware([
            'servers:all'
        ]);

    Route::post('/server/{server}/profile/statistic/payments/{payment}', 'Statistic\PaymentsController@info')
        ->name('admin.statistic.payments.info')
        ->middleware([
            'servers:one',
        ]);

    Route::any('/server/{server}/profile/statistic/payments/complete/{payment}', 'Statistic\PaymentsController@complete')
        ->name('admin.statistic.payments.complete')
        ->middleware([
            'servers:one',
        ]);

    Route::get('/server/{server}/admin/statistic/show', 'Statistic\ShowController@render')
        ->name('admin.statistic.show')
        ->middleware([
            'servers:all'
        ]);

    Route::post('/server/{server}/admin/statistic/flush_cache', 'Statistic\ShowController@flushCache')
        ->name('admin.statistic.flush_cache')
        ->middleware([
            'servers:one'
        ]);
    /**
     * END STATISTIC SECTION
     */

    /**
     * INFORMATION SECTION
     */
    // Render documentation page
    Route::get('/server/{server}/admin/info/docs', 'Info\DocsController@render')
        ->name('admin.info.docs')
        ->middleware([
            'servers:all'
        ]);

    // Render main documentation page
    Route::get('/server/{server}/admin/info/docs/main', 'Info\DocsController@main')
        ->name('admin.info.docs.main')
        ->middleware([
            'servers:all'
        ]);

    // Render API documentation page
    Route::get('/server/{server}/admin/info/docs/api', 'Info\DocsController@api')
        ->name('admin.info.docs.api')
        ->middleware([
            'servers:all'
        ]);

    // Render Sashok724 Launcher integration page
    Route::get('/server/{server}/admin/info/docs/sashok_launcher_integration', 'Info\DocsController@sashokLauncherIntegration')
        ->name('admin.info.docs.sashok_launcher_integration')
        ->middleware([
            'servers:all'
        ]);

    // Render CLI documentation page
    Route::get('/server/{server}/admin/info/docs/cli', 'Info\DocsController@cli')
        ->name('admin.info.docs.cli')
        ->middleware([
            'servers:all'
        ]);

    // Render about page
    Route::get('/server/{server}/admin/info/about', 'Info\AboutController@render')
        ->name('admin.info.about')
        ->middleware([
            'servers:all'
        ]);
    /**
     * END INFORMATION SECTION
     */
});
