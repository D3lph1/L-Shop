<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Requests\Admin\SaveEditedUserRequest;
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
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $user = \Sentinel::findById((int)$request->route('edit'));
        if (!$user) {
            \Message::danger('Пользователь не найден');

            return response()->redirectToRoute('admin.users.list', ['server' => $request->get('currentServer')->id]);
        }
        $data = [
            'currentServer' => $request->get('currentServer'),
            'user' => $user
        ];

        return view('admin.users.edit', $data);
    }

    /**
     * @param SaveEditedUserRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveEditedUserRequest $request)
    {
        $id = (int)$request->route('edit');
        $username = $request->get('username');
        $email = $request->get('email');
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
            $adminRole = \Sentinel::findRoleBySlug('admin');
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
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request)
    {
        $user = \Sentinel::findById((int)$request->route('user'));
        if ($user) {
            $user->delete();
            \Message::info('Пользователь удален');
        }else {
            \Message::danger('Пользователь с таким идентификатором не найден');
        }

        return response()->redirectToRoute('admin.users.list', ['server' => $request->get('currentServer')->id]);
    }

    /**
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
}
