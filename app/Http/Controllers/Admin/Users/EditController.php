<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Users;

use App\DataTransferObjects\Admin\User\Edited;
use App\Exceptions\User\AttemptToBanYourselfException;
use App\Exceptions\User\AttemptToDeleteYourselfException;
use App\Exceptions\User\EmailAlreadyExistsException;
use App\Exceptions\User\NotFoundException;
use App\Exceptions\User\UsernameAlreadyExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlockUserRequest;
use App\Http\Requests\Admin\SaveEditedUserRequest;
use App\Services\Ban;
use App\TransactionScripts\Users;
use Illuminate\Http\JsonResponse;
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
     * @var Users
     */
    private $script;

    public function __construct(Users $script)
    {
        parent::__construct();
        $this->script = $script;
    }

    /**
     * Render the edit given user page.
     */
    public function render(Request $request, Ban $ban): View
    {
        $dto = null;

        try {
            $dto = $this->script->informationForEdit((int)$request->route('edit'));
        } catch (NotFoundException $e) {
            $this->app->abort(404);
        }

        return view('admin.users.edit', [
            'currentServer' => $request->get('currentServer'),
            'servers' => $request->get('servers'),
            'user' => $dto->getUser(),
            'ban' => $ban,
            'isBanned' => $ban->isBanned($dto->getUser()),
            'cart' => $dto->getUserCartContent()
        ]);
    }

    /**
     * Handle the save editable user request.
     */
    public function save(SaveEditedUserRequest $request): RedirectResponse
    {
        $dto = (new Edited())
            ->setId((int)$request->route('edit'))
            ->setUsername($request->get('username'))
            ->setEmail($request->get('email'))
            ->setPassword($request->get('password'))
            ->setBalance((float)$request->get('balance'))
            ->setAdmin((bool)$request->get('admin'));

        try {
            if ($this->script->edit($dto)) {
                $this->msg->success(__('messages.admin.users.edit.save.success'));
            } else {
                $this->msg->danger(__('messages.admin.users.edit.save.fail'));
            }
        } catch (UsernameAlreadyExistsException $e) {
            $this->msg->danger(__('messages.admin.users.edit.save.not_found'));

            return response()->redirectToRoute('admin.users.list', ['server' => $request->get('currentServer')->getId()]);
        } catch (EmailAlreadyExistsException $e) {
            $this->msg->danger(__('messages.admin.users.edit.save.username_already_exists', compact('username')));

            return back();
        }

        return response()->redirectToRoute('admin.users.list', ['server' => $request->get('currentServer')->getId()]);
    }

    /**
     * Remove given user request.
     */
    public function remove(Request $request): RedirectResponse
    {
        try {
            if ($this->script->delete((int)$request->route('user'))) {
                $this->msg->info(__('messages.admin.users.edit.remove.success'));
            }
        } catch (NotFoundException $e) {
            $this->msg->danger(__('messages.admin.users.edit.remove.not_found'));
        } catch (AttemptToDeleteYourselfException $e) {
            $this->msg->warning(__('messages.admin.users.edit.remove.self'));

            return back();
        }

        return response()->redirectToRoute('admin.users.list', ['server' => $request->get('currentServer')->getId()]);
    }

    /**
     * Destroy all login-sessions for given user.
     */
    public function destroySessions(Request $request): RedirectResponse
    {
        try {
            if ($this->script->destroySessions((int)$request->route('user'))) {
                $this->msg->info(__('messages.admin.users.edit.sessions.success'));
            } else {
                $this->msg->danger(__('messages.admin.users.edit.sessions.fail'));
            }
        } catch (NotFoundException $e) {
            $this->msg->danger(__('messages.admin.users.edit.remove.not_found'));
        }

        return back();
    }

    /**
     * Block this user.
     */
    public function block(BlockUserRequest $request): JsonResponse
    {
        $duration = (int)$request->get('block_duration');

        try {
            $result = $this->script->block(
                (int)$request->route('user'),
                $duration,
                $request->get('reason')
            );
        } catch (NotFoundException $e) {
            return json_response('user_not_found', [
                'message' => [
                    'type' => 'danger',
                    'text' => __('messages.admin.users.edit.block.not_found')
                ]
            ]);
        } catch (AttemptToBanYourselfException $e) {
            return json_response('cannot_block_yourself', [
                'message' => [
                    'type' => 'warning',
                    'text' => __('messages.admin.users.edit.block.cannot_block_yourself'),
                ]
            ]);
        }

        if ($result) {
            return json_response('success', [
                'message' => [
                    'type' => 'info',
                    'text' => build_ban_message($duration === 0 ? null : $result->getUntil(), $result->getReason())
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
    public function unblock(Request $request): RedirectResponse
    {
        try {
            if ($this->script->pardon((int)$request->route('user'))) {
                $this->msg->info(__('messages.admin.users.edit.unblock.success'));
            } else {
                $this->msg->danger(__('messages.admin.users.edit.unblock.fail'));
            }
        } catch (NotFoundException $e) {
            $this->msg->danger(__('messages.admin.users.edit.unblock.not_found'));

            return response()->redirectToRoute('admin.users.list', ['server' => $request->get('currentServer')->getId()]);
        }

        return back();
    }
}
