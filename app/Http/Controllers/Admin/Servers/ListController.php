<?php

namespace App\Http\Controllers\Admin\Servers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListController extends Controller
{
    /**
     * Render page with servers list
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $servers = $this->qm->serversWithCategories([
            'servers.id',
            'servers.name',
            'servers.enabled'
        ]);

        $data = [
            'currentServer' => $request->get('currentServer'),
            'servers' => $servers
        ];

        return view('admin.servers.list', $data);
    }

    /**
     * Enable given server
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enable(Request $request)
    {
        $server = $request->route('enable');
        $this->qm->enableServer($server);
        \Message::info('Сервер включен');

        return back();
    }

    /**
     * Disable given server
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disable(Request $request)
    {
        $server = $request->route('disable');
        $this->qm->disableServer($server);
        \Message::info('Сервер отключен');

        return back();
    }
}
