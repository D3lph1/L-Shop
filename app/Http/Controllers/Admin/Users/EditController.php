<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlockUserRequest;
use App\Http\Requests\Admin\SaveEditedUserRequest;
use App\Models\User;
use App\Repositories\BanRepository;
use App\Repositories\CartRepository;
use App\Services\Ban;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Cartalyst\Sentinel\Users\UserInterface;
use Illuminate\Http\Request;

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
        $user = $this->sentinel->getUserRepository()->findById((int)$request->route('edit'));
        if (!$user) {
            \App::abort(404);
        }

        $ban = $this->app->makeWith(Ban::class, ['user' => $user, 'repository' => $banRepository]);

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
        $user = $this->sentinel->getUserRepository()->findById($id);
        if (!$user) {
            $this->msg->danger(__('messages.admin.users.edit.save.not_found'));

            return response()->redirectToRoute('admin.users.list', ['server' => $request->get('currentServer')->id]);
        }
        $admin = $request->get('admin');

        $update = [
            'username' => $username,
            'email' => $email,
            'balance' => (double)$request->get('balance')
        ];

        $other = $this->sentinel->getUserRepository()->findByCredentials(['username' => $username]);
        if ($other and $other->getUserId() !== $id) {
            $this->msg->danger(__('messages.admin.users.edit.save.username_already_exists', compact('username')));

            return back();
        }

        $other = $this->sentinel->getUserRepository()->findByCredentials(['email' => $email]);
        if ($other and $other->getUserId() !== $id) {
            $this->msg->danger(__('messages.admin.users.edit.save.email_already_exists', compact('email')));

            return back();
        }

        if ($request->get('password')) {
            $update['password'] = bcrypt($request->get('password'));
        }
        if ($user->update($update)) {
            /** @var EloquentRole $adminRole */
            $adminRole = $this->sentinel->getRoleRepository()->findBySlug('admin');

            /** @var EloquentRole $userRole */
            $userRole = $this->sentinel->getRoleRepository()->findBySlug('user');
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
            $this->msg->success(__('messages.admin.users.edit.save.success'));
        }else {
            $this->msg->danger(__('messages.admin.users.edit.save.fail'));
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
        $user = $this->sentinel->getUserRepository()->findById((int)$request->route('user'));
        if ($user) {

            if ($user->getUserId() === $this->sentinel->getUser()->getUserId()) {
                $this->msg->warning('Вы не можите удалить самого себя');

                return back();
            }

            $user->delete();
            $this->msg->info('Пользователь удален');
        }else {
            $this->msg->danger('Пользователь с таким идентификатором не найден');
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
        $user = $this->sentinel->getUserRepository()->findById($request->route('user'));

        if (!$user) {
            $this->msg->danger('Пользователь не найден');

            return back();
        }

        $result = $this->sentinel->logout($user, true);

        if ($result) {
            $this->msg->info('Логин-сессии данного пользователя успешно сброшены!');
        }else {
            $this->msg->danger('Не удалось сбросить логин-сессии данного пользователя!');
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
        $user = $this->sentinel->getUserRepository()->findById((int)$request->route('user'));
        $duration = (int)$request->get('block_duration');
        $reason = $request->get('reason');

        if (!$user) {
            return json_response('user_not_found', [
                'message' => [
                    'type' => 'danger',
                    'text' => __('messages.admin.users.edit.block.not_found')
                ]
            ]);
        }

        if ($user->getUserId() === \Sentinel::getUser()->getUserId()) {
            return json_response('cannot_block_yourself', [
                'message' => [
                    'type' => 'warning',
                    'text' => __('messages.admin.users.edit.block.cannot_block_yourself'),
                ]
            ]);
        }

        /** @var Ban $ban */
        $ban = $this->app->makeWith(Ban::class, ['user' => $user, 'repository' => $banRepository]);

        $result = $ban->banForDays($duration, $reason);

        if ($result) {
            return json_response('success', [
                'message' => [
                    'type' => 'info',
                    'text' => build_ban_message($duration === 0 ? null : $result->until->toDateTimeString(), $result->reason)
                ]
            ]);
        }

        return json_response('fail', [
            'message' => [
                'type' => 'danger',
                'text' => __('messages.admin.users.edit.block.fail')
            ]
        ]);
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
        $user = $this->sentinel->getUserRepository()->findById((int)$request->route('user'));

        if (!$user) {
            $this->msg->danger(__('messages.admin.users.edit.unblock.not_found'));

            return response()->redirectToRoute('admin.users.list', ['server' => $request->get('currentServer')->id]);
        }

        /** @var Ban $ban */
        $ban = $this->app->makeWith(Ban::class, ['user' => $user, 'repository' => $banRepository]);

        if ($ban->unblock()) {
            $this->msg->info(__('messages.admin.users.edit.unblock.success'));
        } else {
            $this->msg->danger(__('messages.admin.users.edit.unblock.fail'));
        }

        return back();
    }
}
