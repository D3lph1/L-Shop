<?php

namespace App\Http\Controllers\Admin\Users;

use App\Models\User;
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
    /**
     * Render the users list page.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $users = \Sentinel::getUserRepository()->with(['roles', 'activations', 'ban'])->paginate(50);

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
        $user = \Sentinel::findById((int)$request->route('user'));
        $activation = \Activation::completed($user);
        if ($activation) {
            \Message::info('Аккаунт пользователя уже подтвержден');

            return back();
        }

        \Sentinel::activate($user);
        \Message::success('Аккаунт пользователя подтвержден');

        return back();
    }

    /**
     * Search given user.
     *
     * @param Request  $request
     * @param Sentinel $sentinel
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request, Sentinel $sentinel)
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

        return json_response('not found');
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
        /** @var Builder $builder */
        $builder = User::select(['id', 'username', 'email', 'balance']);

        $first = $search[0];
        if ($first === '>' or $first === '<' or $first === '=' or $first === '>=' or $first === '<=' or $first === '<>' or $first === '<>') {
            $result = $builder
                ->where('balance', $first, str_replace($first, '', $search))
                ->get();
        } else {
            $pattern = '%' . $search . '%';
            $result = $builder
                ->where('id', 'like', $pattern)
                ->orWhere('username', 'like', $pattern)
                ->orWhere('email', 'like', $pattern)
                ->orWhere('balance', 'like', $pattern)
                ->get();
        }

        return $result->toArray();
    }
}
