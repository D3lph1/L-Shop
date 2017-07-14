<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Requests\Admin\BlockUserRequest;
use App\Http\Requests\Admin\SaveEditedUserRequest;
use App\Models\User;
use App\Repositories\BanRepository;
use App\Repositories\CartRepository;
use App\Services\Ban;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Cartalyst\Sentinel\Users\UserInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class EditController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Users
 */
class EditController extends Controller
{
    /**
     * Render the edit given user page.
     *
     * @param Request        $request
     * @param BanRepository  $banRepository
     * @param CartRepository $cartRepository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function render(Request $request, BanRepository $banRepository, CartRepository $cartRepository)
    {
        /** @var User $user */
        $user = \Sentinel::findById((int)$request->route('edit'));
        if (!$user) {
            \App::abort(404);
        }

        $ban = app(Ban::class, ['user' => $user, 'repository' => $banRepository]);

        $data = [
            'currentServer' => $request->get('currentServer'),
            'servers' => $request->get('servers'),
            'user' => $user,
            'ban' => $ban,
            'cart' => $cartRepository->getByPlayerWithItems($user->username)
        ];

        return view('admin.users.edit', $data);
    }

    /**
     * Handle the save editable user request.
     *
     * @param SaveEditedUserRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveEditedUserRequest $request)
    {
        $id = (int)$request->route('edit');
        $username = $request->get('username');
        $email = $request->get('email');

        /** @var User $user */
        $user = \Sentinel::findById($id);
        if (!$user) {
            \Message::danger('Пользователь не найден');

            return response()->redirectToRoute('admin.users.list', ['server' => $request->get('currentServer')->id]);
        }
        $admin = $request->get('admin');

        $update = [
            'username' => $username,
            'email' => $email,
            'balance' => (double)$request->get('balance')
        ];

        $other = \Sentinel::findByCredentials(['username' => $username]);
        if ($other and $other->id !== $id) {
            \Message::danger('Пользователь с таким именем уже существует');

            return back();
        }

        $other = \Sentinel::findByCredentials(['email' => $email]);
        if ($other and $other->id !== $id) {
            \Message::danger('Пользователь с такой почтой уже существует');

            return back();
        }

        if ($request->get('password')) {
            $update['password'] = bcrypt($request->get('password'));
        }
        if ($user->update($update)) {
            /** @var EloquentRole $adminRole */
            $adminRole = \Sentinel::findRoleBySlug('admin');

            /** @var EloquentRole $userRole */
            $userRole = \Sentinel::findRoleBySlug('user');
            if ($admin) {
                if (!$user->inRole($adminRole)) {
                    $userRole->users()->detach($user);
                    $adminRole->users()->attach($user);
                }
            }else {
                if (!$user->inRole($userRole)) {
                    $adminRole->users()->detach($user);
                    $userRole->users()->attach($user);
                }
            }
            \Message::info('Пользователь изменен');
        }else {
            \Message::danger('Изменения не сохранены');
        }

        return response()->redirectToRoute('admin.users.list', ['server' => $request->get('currentServer')->id]);
    }

    /**
     * Remove given user request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request)
    {
        /** @var UserInterface|User $user */
        $user = \Sentinel::findById((int)$request->route('user'));
        if ($user) {

            if ($user->getUserId() === \Sentinel::getUser()->getUserId()) {
                \Message::warning('Вы не можите удалить самого себя');

                return back();
            }

            $user->delete();
            \Message::info('Пользователь удален');
        }else {
            \Message::danger('Пользователь с таким идентификатором не найден');
        }

        return response()->redirectToRoute('admin.users.list', ['server' => $request->get('currentServer')->id]);
    }

    /**
     * Destroy all login-sessions for given user.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroySessions(Request $request)
    {
        $user = \Sentinel::getUserRepository()->findById($request->route('user'));

        if (!$user) {
            \Message::danger('Пользователь не найден');

            return back();
        }

        $result = \Sentinel::logout($user, true);

        if ($result) {
            \Message::info('Логин-сессии данного пользователя успешно сброшены!');
        }else {
            \Message::danger('Не удалось сбросить логин-сессии данного пользователя!');
        }

        return back();
    }

    /**
     * Block this user.
     *
     * @param BlockUserRequest $request
     * @param BanRepository            $banRepository
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function block(BlockUserRequest $request, BanRepository $banRepository)
    {
        /** @var User|UserInterface $user */
        $user = \Sentinel::findById((int)$request->route('user'));
        $duration = (int)$request->get('duration');
        $reason = $request->get('reason');

        if (!$user) {
            json_response('user not found');

            return json_response('user not found');
        }

        if ($user->getUserId() === \Sentinel::getUser()->getUserId()) {
            return json_response('You can not block yourself');
        }

        /** @var Ban $ban */
        $ban = app(Ban::class, ['user' => $user, 'repository' => $banRepository]);

        $result = $ban->banForDays($duration, $reason);

        if ($result) {
            return json_response('success', [
                'unblock' => build_ban_message($result->until, $result->reason)
            ]);
        }

        return json_response('failed');
    }

    /**
     * Unblock this user.
     *
     * @param Request       $request
     * @param BanRepository $banRepository
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unblock(Request $request, BanRepository $banRepository)
    {
        /** @var User|UserInterface $user */
        $user = \Sentinel::findById((int)$request->route('user'));

        if (!$user) {
            \Message::danger('Пользователь не найден');

            return response()->redirectToRoute('admin.users.list', ['server' => $request->get('currentServer')->id]);
        }

        /** @var Ban $ban */
        $ban = app(Ban::class, ['user' => $user, 'repository' => $banRepository]);

        if ($ban->unblock()) {
            \Message::info('Пользователь разблокирован');
        } else {
            \Message::danger('Неудалось разблокировать пользователя');
        }

        return back();
    }
}
