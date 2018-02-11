<?php
declare(strict_types = 1);

use App\Services\Auth\Permissions;
use function App\permission_middleware;

$router->get('/control/basic', 'Control\BasicController@render')
    ->name('admin.control.basic.render')
    ->middleware(permission_middleware(Permissions::ADMIN_CONTROL_BASIC_ACCESS));

/** @var \Illuminate\Routing\Router $router */
$router->get('/information/about', 'Information\AboutController@render')
    ->name('admin.information.about.render')
    ->middleware(permission_middleware(Permissions::ADMIN_INFORMATION_ABOUT_ACCESS));
