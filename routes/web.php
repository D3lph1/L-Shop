<?php

Route::group(['namespace' => 'Auth'], function () {
    // Render sign in page
    Route::get('/signin', 'SignInController@render')
        ->name('signin')
        ->middleware('guest');

    // Authorize user by POST-request
    Route::post('/signin', 'SignInController@signin')->middleware('guest');

    // Logout user
    Route::get('/logout', 'SignInController@logout')
        ->name('logout')
        ->middleware('auth');

    // Render sign up page
    Route::get('/signup', 'SignUpController@render');

    // Register user
    Route::post('/signup', 'SignUpController@signup');

    // Render select server page
    Route::get('/servers', 'SelectServerController@render')->name('servers');
});

Route::group(['namespace' => 'Shop'], function () {
    // Route of main shop page
    Route::get('/server/{server}/{category?}', 'CatalogController@render')
        ->name('catalog')
        ->where([
            'server' => '\d+',
            'category' => '\d+'
        ]);
});

Route::group(['namespace' => 'Components'], function () {
    Route::get('/server/{server}/cart', 'CartController@render')
        ->name('cart')
        ->where('server', '\d+');

    Route::post('/server/{server}/cart', 'CartController@pay')
        ->name('cart.pay')
        ->where('server', '\d+');;

    Route::post('/server/{server}/cart/put/{product}', 'CartController@put')
        ->name('cart.put')
        ->where([
            'server' => '\d+',
            'product' => '\d+'
        ]);

    Route::post('/server/{server}/cart/remove/{product}', 'CartController@remove')
        ->name('cart.remove')
        ->where([
            'server' => '\d+',
            'product' => '\d+'
        ]);

    Route::get('/server/{server}/payment/cart', 'PaymentController@render')
        ->name('payment.cart')
        ->where('server', '\d+');
});
