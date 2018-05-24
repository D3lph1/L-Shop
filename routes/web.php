<?php
declare(strict_types = 1);

/** @var \Illuminate\Routing\Router $router */
$router->any('/payment/result/{payer}', 'Frontend\Shop\PaymentController@result')
    ->name('frontend.payment.result');
$router->any('/payment/wait', 'Frontend\Shop\PaymentController@wait')
    ->name('frontend.payment.wait');
$router->any('/payment/error', 'Frontend\Shop\PaymentController@error')
    ->name('frontend.payment.error');

$router->get('{all}', 'SpaController@render')
    ->where('all', '(.*)');
