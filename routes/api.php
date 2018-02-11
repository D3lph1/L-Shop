<?php

/** @var \Illuminate\Routing\Router $router */
$router->any('/user/skin/front/{username}', 'User\SkinController@front')
    ->name('api.user.skin.front');
$router->any('/user/skin/back/{username}', 'User\SkinController@back')
    ->name('api.user.skin.back');
$router->any('/user/cloak/front/{username}', 'User\CloakController@front')
    ->name('api.user.cloak.front');
$router->any('/user/cloak/back/{username}', 'User\CloakController@back')
    ->name('api.user.cloak.back');
