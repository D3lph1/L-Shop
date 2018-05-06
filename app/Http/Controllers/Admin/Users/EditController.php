<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Users;

use App\DataTransferObjects\Admin\Users\Edit\AddBan;
use App\DataTransferObjects\Admin\Users\Edit\Edit;
use App\Exceptions\Ban\BanNotFoundException;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\Media\Character\InvalidRatioException;
use App\Exceptions\User\UserNotFoundException;
use App\Handlers\Admin\Users\Edit\AddBanHandler;
use App\Handlers\Admin\Users\Edit\DeleteBanHandler;
use App\Handlers\Admin\Users\Edit\DeleteCloakHandler;
use App\Handlers\Admin\Users\Edit\DeleteSkinHandler;
use App\Handlers\Admin\Users\Edit\EditHandler;
use App\Handlers\Admin\Users\Edit\RenderHandler;
use App\Handlers\Admin\Users\Edit\UploadCloakHandler;
use App\Handlers\Admin\Users\Edit\UploadSkinHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\Edit\AddBanRequest;
use App\Http\Requests\Admin\Users\Edit\EditRequest;
use App\Http\Requests\Admin\Users\Edit\UploadSkinCloakRequest;
use App\Services\Auth\Exceptions\EmailAlreadyExistsException;
use App\Services\Auth\Exceptions\UsernameAlreadyExistsException;
use App\Services\Auth\Permissions;
use App\Services\Infrastructure\Notification\Notifications\Error;
use App\Services\Infrastructure\Notification\Notifications\Info;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function App\permission_middleware;

class EditController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_USERS_CRUD_ACCESS));
    }

    public function render(Request $request, RenderHandler $handler): JsonResponse
    {
        try {
            $dto = $handler->handle((int)$request->route('user'));

            return new JsonResponse(Status::SUCCESS, [
                'user' => $dto->getUser(),
                'roles' => $dto->getRoles(),
                'permissions' => $dto->getPermissions()
            ]);
        } catch (UserNotFoundException $e) {
            throw new NotFoundHttpException();
        }
    }

    public function edit(EditRequest $request, EditHandler $handler): JsonResponse
    {
        $dto = (new Edit())
            ->setUserId((int)$request->route('user'))
            ->setUsername($request->get('username'))
            ->setEmail($request->get('email'))
            ->setPassword($request->get('password'))
            ->setRoles($request->get('roles'))
            ->setPermissions($request->get('permissions'));

        try {
            $handler->handle($dto);

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Success(__('msg.admin.users.edit.success')));
        } catch (UserNotFoundException $e) {
            return (new JsonResponse(__('msg.admin.users.edit.user_not_found')))
                ->addNotification(new Error(__('msg.admin.users.edit.user_not_found')));
        } catch (UsernameAlreadyExistsException $e) {
            return (new JsonResponse(__('msg.admin.users.edit.success')))
                ->addNotification(new Error(__('msg.admin.users.edit.username_already_exists')));
        } catch (EmailAlreadyExistsException $e) {
            return (new JsonResponse(__('msg.admin.users.edit.success')))
                ->addNotification(new Error(__('msg.admin.users.edit.email_already_exists')));
        }
    }

    public function uploadSkin(UploadSkinCloakRequest $request, UploadSkinHandler $handler): JsonResponse
    {
        try {
            $handler->handle((int)$request->route('user'), $request->file('file'));

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Success(__('msg.frontend.profile.skin.success')));
        } catch (UserNotFoundException $e) {
            return (new JsonResponse('user_not_found'))
                ->addNotification(new Error(__('msg.user_not_found')));
        } catch (InvalidRatioException $e) {
            return (new JsonResponse('invalid_ration'))
                ->addNotification(new Error(__('msg.frontend.profile.skin.invalid_ratio')));
        }
    }

    public function uploadCloak(UploadSkinCloakRequest $request, UploadCloakHandler $handler): JsonResponse
    {
        try {
            $handler->handle((int)$request->route('user'), $request->file('file'));

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Success(__('msg.frontend.profile.cloak.success')));
        } catch (UserNotFoundException $e) {
            return (new JsonResponse('user_not_found'))
                ->addNotification(new Error(__('msg.user_not_found')));
        } catch (InvalidRatioException $e) {
            return (new JsonResponse('invalid_ration'))
                ->addNotification(new Error(__('msg.frontend.profile.cloak.invalid_ratio')));
        }
    }

    public function deleteSkin(Request $request, DeleteSkinHandler $handler): JsonResponse
    {
        try {
            if ($handler->handle((int)$request->route('user'))) {
                return (new JsonResponse(Status::SUCCESS))
                    ->addNotification(new Info(__('msg.frontend.profile.skin.delete.success')));
            }

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Error(__('msg.frontend.profile.skin.delete.fail')));
        } catch (UserNotFoundException $e) {
            return (new JsonResponse('user_not_found'))
                ->addNotification(new Error(__('msg.user_not_found')));
        }
    }

    public function deleteCloak(Request $request, DeleteCloakHandler $handler): JsonResponse
    {
        try {
            if ($handler->handle((int)$request->route('user'))) {
                return (new JsonResponse(Status::SUCCESS))
                    ->addNotification(new Info(__('msg.frontend.profile.cloak.delete.success')));
            }

            return (new JsonResponse(Status::FAILURE))
                ->addNotification(new Error(__('msg.frontend.profile.cloak.delete.fail')));
        } catch (UserNotFoundException $e) {
            return (new JsonResponse('user_not_found'))
                ->addNotification(new Error(__('msg.user_not_found')));
        }
    }

    public function addBan(AddBanRequest $request, AddBanHandler $handler): JsonResponse
    {
        $dto = (new AddBan())
            ->setUserId((int)$request->route('user'))
            ->setMode($request->get('mode'))
            ->setForever((bool)$request->get('forever'))
            ->setDateTime($request->get('date_time'))
            ->setDays((int)$request->get('days'))
            ->setReason($request->get('reason'));

        try {
            $ban = $handler->handle($dto);

            return (new JsonResponse(Status::SUCCESS, [
                'ban' => $ban
            ]))
                ->addNotification(new Info(__('msg.admin.users.edit.ban.add.success')));
        } catch (UserNotFoundException $e) {
            return (new JsonResponse('user_not_found'))
                ->addNotification(new Error(__('msg.admin.users.edit.ban.add.user_not_found')));
        } catch (InvalidArgumentException $e) {
            return (new JsonResponse('date_time_empty'))
                ->addNotification(new Error(__('validation.required', [
                    'attribute' => __('content.admin.users.edit.actions.add_ban.DateTime')
                ])));
        }
    }

    public function deleteBan(Request $request, DeleteBanHandler $handler): JsonResponse
    {
        try {
            $handler->handle((int)$request->route('ban'));

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Info(__('msg.admin.users.edit.ban.delete.success')));
        } catch (BanNotFoundException $e) {
            return (new JsonResponse('not_found'))
                ->addNotification(new Error(__('msg.admin.users.edit.ban.delete.not_found')));
        }
    }
}
