<?php
declare(strict_types = 1);

/** @var \Illuminate\Routing\Router $router */
$router->any('/payment/result/{payer}', 'Frontend\Shop\PaymentController@result');
$router->any('/payment/wait', 'Frontend\Shop\PaymentController@wait');
$router->any('/payment/error', 'Frontend\Shop\PaymentController@error');

$router->get('{all}', 'SpaController@render')
    ->where('all', '(.*)');
