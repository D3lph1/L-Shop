<?php
declare(strict_types = 1);

/** @var \Illuminate\Routing\Router $router */
$router->get('{all}', 'SpaController@render')
    ->where('all', '(.*)');
