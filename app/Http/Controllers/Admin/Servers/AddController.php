<?php

namespace App\Http\Controllers\Admin\Servers;

use App\Http\Requests\Admin\SaveAddedServerRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class AddController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Servers
 */
class AddController extends BaseController
{
    /**
     * Render the add new server page
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $data = [
            'currentServer' => $request->get('currentServer')
        ];

        return view('admin.servers.add', $data);
    }

    /**
     * @param SaveAddedServerRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveAddedServerRequest $request)
    {
        $name = $request->get('server_name');
        $enabled = (bool)$request->get('enabled');
        $categories = $request->get('categories');
        $ip = $request->get('server_ip');
        $port = $request->get('server_port');
        $password = $request->get('server_password');
        $monitoringEnabled = (bool)$request->get('server_monitoring_enabled');

        // ~~~~~~~~~~ MAIN METHOD ~~~~~~~~~~ //
        $this->serverService->createServer($name, $enabled, $categories, $ip, $port, $password, $monitoringEnabled);

        \Message::success("Сервер \"{$request->get('server_name')}\" успешно создан.");

        return response()->redirectToRoute('admin.servers.list', [
            'server' => $request->get('currentServer')->id
        ]);
    }
}
