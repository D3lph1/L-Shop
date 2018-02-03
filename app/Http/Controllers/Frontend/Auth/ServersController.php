<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Handlers\Frontend\Auth\ServersHandler;
use App\Http\Controllers\Controller;
use App\Services\Auth\AccessMode;
use App\Services\Auth\Auth;
use App\Services\Settings\Settings;

class ServersController extends Controller
{
    public function render(ServersHandler $handler, Auth $auth, Settings $settings)
    {
        return view('frontend.auth.servers', [
            'servers' => $handler->servers(),
            'allowLogin' => $settings->get('auth.access_mode')->getValue() === AccessMode::ANY ||
                $settings->get('auth.access_mode')->getValue() === AccessMode::AUTH,
            'isAuth' => $auth->check()
        ]);
    }
}
