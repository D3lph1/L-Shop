<?php

namespace App\Http\Controllers\Admin\Users;

use App\Models\User;
use App\Repositories\UserRepository;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ListController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Users
 */
class ListController extends Controller
{
    private $searchSpecials = ['>', '<', '=', '>=', '<=', '!=', '<>'];

    /**
     * Render the users list page.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $users = $this->sentinel->getUserRepository()->with(['roles', 'activations', 'ban'])->paginate(50);

        $data = [
            'currentServer' => $request->get('currentServer'),
            'users' => $users
        ];

        return view('admin.users.list', $data);
    }

    /**
     * Activate given user.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function complete(Request $request)
    {
        $user = $this->sentinel->findById((int)$request->route('user'));
        $activation = $this->sentinel->getActivationRepository()->completed($user);
        if ($activation) {
            $this->msg->info(__('messages.admin.users.list.activate.already'));

            return back();
        }

        $this->sentinel->activate($user);
        $this->msg->success(__('messages.admin.users.list.activate.success'));

        return back();
    }

    /**
     * Search given user.
     *
     * @param Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $search = $request->get('search');
        $result = $this->getResult($search);

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

    /**
     * Get user search result.
     *
     * @param string $search Query string.
     *
     * @return array
     */
    protected function getResult($search)
    {
        return $this->app->make(UserRepository::class)->search($search, $this->searchSpecials);
    }
}
