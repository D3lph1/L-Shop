<?php

Route::group(['namespace' => 'Auth'], function () {
    // Render sign in page
    Route::get('/signin', 'SignInController@render')->name('signin')->middleware('guest');

    // Authorize user by GET-request (with redirect)
    Route::get('/signin_get', 'SignInController@get')->middleware('guest');

    // Authorize user by POST-request
    Route::post('/signin', 'SignInController@signin')->middleware('guest');

    // Logout user
    Route::get('/logout', 'SignInController@logout')->middleware('auth');

    // Render sign up page
    Route::get('/signup', 'SignUpController@render');

    // Register user
    Route::post('/signup', 'SignUpController@signup');

    // Render select server page
    Route::get('/servers', 'SelectServerController@render')->name('servers');
});

Route::group(['namespace' => 'Shop'], function () {
    // Route of main shop page
    Route::get('/server/{server}', 'CatalogController@render')->where('server', '\d+');
});
