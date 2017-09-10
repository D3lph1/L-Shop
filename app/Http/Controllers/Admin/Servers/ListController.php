<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Servers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Class ListController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Server
 */
class ListController extends BaseController
{
    /**
     * Render page with servers list
     */
    public function render(Request $request): View
    {
        $servers = $this->serverRepository->getWithCategories([
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
     */
    public function enable(Request $request): RedirectResponse
    {
        $serverId = (int)$request->route('enable');

        if ($this->serverService->enableServer($serverId)) {
            $this->msg->info(__('messages.admin.servers.list.enable.success'));
            $code = 302;
        } else {
            $this->msg->danger(__('messages.admin.servers.list.enable.fail'));
            $code = 400;
        }

        return back($code);
    }

    /**
     * Disable given server
     */
    public function disable(Request $request): RedirectResponse
    {
        $serverId = (int)$request->route('disable');

        if ($this->serverService->disableServer($serverId)) {
            $this->msg->info(__('messages.admin.servers.list.disable.success'));
        } else {
            $this->msg->danger(__('messages.admin.servers.list.disable.fail'));
        }

        return back();
    }
}
