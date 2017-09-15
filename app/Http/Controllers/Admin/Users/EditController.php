<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlockUserRequest;
use App\Http\Requests\Admin\SaveEditedUserRequest;
use App\Models\User\UserInterface;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Services\Ban;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class EditController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Users
 */
class EditController extends Controller
{
    /**
     * Render the edit given user page.
     */
    public function render(Request $request, CartRepositoryInterface $cartRepository, Ban $ban): View
    {
        /** @var UserInterface $user */
        $user = $this->sentinel->getUserRepository()->findById((int)$request->route('edit'));
        if (!$user) {
            $this->app->abort(404);
        }

        $data = [
            'currentServer' => $request->get('currentServer'),
            'servers' => $request->get('servers'),
            'user' => $user,
            'ban' => $ban,
            'isBanned' => $ban->isBanned($user),
            'cart' => $cartRepository->getByPlayerWithItems($user->getUsername(), [])
        ];

        return view('admin.users.edit', $data);
    }

    /**
     * Handle the save editable user request.
     */
    public function save(SaveEditedUserRequest $request): RedirectResponse
    {
        $id = (int)$request->route('edit');
        $username = $request->get('username');
        $email = $request->get('email');

        /** @var UserInterface $user */
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
     */
    public function remove(Request $request): RedirectResponse
    {
        /** @var UserInterface $user */
        $user = $this->sentinel->getUserRepository()->findById((int)$request->route('user'));
        if ($user) {

            if ($user->getId() === $this->sentinel->getUser()->getId()) {
                $this->msg->warning(__('messages.admin.users.edit.remove.self'));

                return back();
            }

            $user->delete();
            $this->msg->info(__('messages.admin.users.edit.remove.success'));
        }else {
            $this->msg->danger(__('messages.admin.users.edit.remove.not_found'));
        }

        return response()->redirectToRoute('admin.users.list', ['server' => $request->get('currentServer')->id]);
    }

    /**
     * Destroy all login-sessions for given user.
     */
    public function destroySessions(Request $request): RedirectResponse
    {
        $user = $this->sentinel->getUserRepository()->findById($request->route('user'));

        if (!$user) {
            $this->msg->danger(__('messages.admin.users.edit.remove.not_found'));

            return back();
        }

        $result = $this->sentinel->logout($user, true);

        if ($result) {
            $this->msg->info(__('messages.admin.users.edit.sessions.success'));
        }else {
            $this->msg->danger(__('messages.admin.users.edit.sessions.fail'));
        }

        return back();
    }

    /**
     * Block this user.
     */
    public function block(BlockUserRequest $request, Ban $ban): RedirectResponse
    {
        /** @var UserInterface $user */
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

        if ($user->getId() === $this->sentinel->getUser()->getId()) {
            return json_response('cannot_block_yourself', [
                'message' => [
                    'type' => 'warning',
                    'text' => __('messages.admin.users.edit.block.cannot_block_yourself'),
                ]
            ]);
        }

        if ($duration === 0) {
            $result = $ban->permanently($user, $reason);
        } else {
            $result = $ban->forDays($user, $duration, $reason);
        }

        if ($result) {
            return json_response('success', [
                'message' => [
                    'type' => 'info',
                    'text' => build_ban_message($duration === 0 ? null : $result->getUntil()->toDateTimeString(), $result->reason)
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
     */
    public function unblock(Request $request, Ban $ban): RedirectResponse
    {
        /** @var UserInterface $user */
        $user = $this->sentinel->getUserRepository()->findById((int)$request->route('user'));

        if (!$user) {
            $this->msg->danger(__('messages.admin.users.edit.unblock.not_found'));

            return response()->redirectToRoute('admin.users.list', ['server' => $request->get('currentServer')->id]);
        }

        if ($ban->pardon($user)) {
            $this->msg->info(__('messages.admin.users.edit.unblock.success'));
        } else {
            $this->msg->danger(__('messages.admin.users.edit.unblock.fail'));
        }

        return back();
    }
}
