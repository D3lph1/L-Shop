<?php
declare(strict_types = 1);

/** @var \Illuminate\Routing\Router $router */
$router->any('/payment/result/{payer}', 'Frontend\Shop\PaymentController@result')
    ->name('frontend.payment.result');
$router->any('/payment/wait', 'Frontend\Shop\PaymentController@wait')
    ->name('frontend.payment.wait');
$router->any('/payment/error', 'Frontend\Shop\PaymentController@error')
    ->name('frontend.payment.error');

$router->any('/skin/front/{username}', 'Frontend\Character\SkinController@front')
    ->name('api.skin.front');
$router->any('/skin/back/{username}', 'Frontend\Character\SkinController@back')
    ->name('api.skin.back');
$router->any('/cloak/front/{username}', 'Frontend\Character\CloakController@front')
    ->name('api.cloak.front');
$router->any('/cloak/back/{username}', 'Frontend\Character\CloakController@back')
    ->name('api.cloak.back');

$router->get('{all}', 'SpaController@render')
    ->where('all', '(.*)');
