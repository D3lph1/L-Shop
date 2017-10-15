<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Users;

use App\Exceptions\User\AlreadyActivatedException;
use App\Exceptions\User\NotFoundException;
use App\Http\Controllers\Controller;
use App\Services\Ban;
use App\TransactionScripts\Users;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class ListController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Users
 */
class ListController extends Controller
{
    /**
     * @var Users
     */
    private $script;

    public function __construct(Users $script)
    {
        parent::__construct();
        $this->script = $script;
    }

    /**
     * Render the users list page.
     *
     * @param Request $request
     * @param Ban     $ban
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request, Ban $ban): View
    {
        return view('admin.users.list', [
            'currentServer' => $request->get('currentServer'),
            'ban' => $ban,
            'users' => $this->script->informationForList()
        ]);
    }

    /**
     * Activate given user.
     */
    public function complete(Request $request): RedirectResponse
    {
        try {
            if ($this->script->activate((int)$request->route('user'))) {
                $this->msg->success(__('messages.admin.users.list.activate.success'));
            } else {
                $this->msg->success(__('messages.admin.users.list.activate.fail'));
            }
        } catch (NotFoundException $e) {
            $this->msg->success(__('messages.admin.users.edit.remove.not_found'));
        } catch (AlreadyActivatedException $e) {
            $this->msg->info(__('messages.admin.users.list.activate.already'));
        }

        return back();
    }

    /**
     * Search given user.
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('search');
        if (empty($query)) {
            return json_response('not_found');
        }

        $result = $this->script->search($query);

        if (count($result) > 0) {
            $currency = s_get('shop.currency_html');

            foreach ($result as &$item) {
                $item['url'] = route('admin.users.edit',
                    [
                        'server' => $request->get('currentServer')->id,
                        'edit' => $item['id'],
                    ]);
                $item['currency'] = $currency;
            }
            unset($item);

            return json_response('found', [
                'data' => $result
            ]);
        }

        return json_response('not_found');
    }
}
