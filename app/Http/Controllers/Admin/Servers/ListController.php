<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Servers;

use App\Http\Controllers\Controller;
use App\TransactionScripts\Servers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class ListController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Server
 */
class ListController extends Controller
{
    /**
     * @var Servers
     */
    private $script;

    public function __construct(Servers $script)
    {
        parent::__construct();
        $this->script = $script;
    }

    /**
     * Render page with servers list
     */
    public function render(Request $request): View
    {
        return view('admin.servers.list', [
            'currentServer' => $request->get('currentServer'),
            'servers' => $this->script->informationForList()
        ]);
    }

    /**
     * Enable given server.
     */
    public function enable(Request $request): RedirectResponse
    {
        $serverId = (int)$request->route('enable');

        if ($this->script->enableServer($serverId)) {
            $this->msg->info(__('messages.admin.servers.list.enable.success'));
            $code = 302;
        } else {
            $this->msg->danger(__('messages.admin.servers.list.enable.fail'));
            $code = 400;
        }

        return back($code);
    }

    /**
     * Disable given server.
     */
    public function disable(Request $request): RedirectResponse
    {
        $serverId = (int)$request->route('disable');

        if ($this->script->disableServer($serverId)) {
            $this->msg->info(__('messages.admin.servers.list.disable.success'));
            $code = 302;
        } else {
            $this->msg->danger(__('messages.admin.servers.list.disable.fail'));
            $code = 400;
        }

        return back($code);
    }
}
