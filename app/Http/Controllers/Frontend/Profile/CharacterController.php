<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\Profile;

use App\Exceptions\ForbiddenException;
use App\Exceptions\Media\Character\InvalidRatioException;
use App\Exceptions\Media\Character\InvalidResolutionException;
use App\Handlers\Frontend\Profile\Character\DeleteCloakHandler;
use App\Handlers\Frontend\Profile\Character\DeleteSkinHandler;
use App\Handlers\Frontend\Profile\Character\UploadCloakHandler;
use App\Handlers\Frontend\Profile\Character\UploadSkinHandler;
use App\Handlers\Frontend\Profile\Character\VisitHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Profile\Character\UploadCloakRequest;
use App\Http\Requests\Frontend\Profile\Character\UploadSkinRequest;
use App\Services\Auth\Auth;
use App\Services\Infrastructure\Notification\Notifications\Error;
use App\Services\Infrastructure\Notification\Notifications\Info;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use App\Services\Media\Character\Cloak\Accessor as CloakAccessor;
use App\Services\Media\Character\Skin\Accessor as SkinAccessor;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CharacterController extends Controller
{
    public function __construct(Auth $auth, SkinAccessor $skinAccessor, CloakAccessor $cloakAccessor)
    {
        $this->middleware(function ($request, \Closure $next) use ($auth, $skinAccessor, $cloakAccessor) {
            // Checking user's rights to set skin and/or cloak.
            if (!$auth->check() || !($skinAccessor->allowSet($auth->getUser()) || $cloakAccessor->allowSet($auth->getUser()))) {
                throw new HttpException(403);
            }

            return $next($request);
        });

    }

    public function render(
        Auth $auth,
        Settings $settings,
        VisitHandler $handler): JsonResponse
    {
        $dto = $handler->handle();
        $username = $auth->getUser()->getUsername();

        $skinImageSizes = [];
        foreach ($dto->getAvailableSkinImageSizes() as $item) {
            $skinImageSizes[] = $item[0] . 'x' . $item[1];
        }
        $cloakImageSizes = [];
        foreach ($dto->getAvailableCloakImageSizes() as $item) {
            $cloakImageSizes[] = $item[0] . 'x' . $item[1];
        }

        return new JsonResponse(Status::SUCCESS, [
            'skin' => [
                'allowed' => $dto->isAllowSetSkin(),
                'front' => route('api.skin.front', ['username' => $username]),
                'back' => route('api.skin.back', ['username' => $username]),
                'max_file_size' => $settings->get('system.profile.character.skin.max_file_size')->getValue(DataType::FLOAT),
                'image_sizes' => implode(', ', $skinImageSizes),
                'default' => $dto->isSkinDefault(),
            ],
            'cloak' => [
                'allowed' => $dto->isAllowSetCloak(),
                'front' => route('api.cloak.front', ['username' => $username]),
                'back' => route('api.cloak.back', ['username' => $username]),
                'max_file_size' => $settings->get('system.profile.character.cloak.max_file_size')->getValue(DataType::FLOAT),
                'image_sizes' => implode(', ', $cloakImageSizes),
                'exists' => $dto->isCloakExists(),
            ]
        ]);
    }

    public function uploadSkin(UploadSkinRequest $request, UploadSkinHandler $handler, LoggerInterface $logger): JsonResponse
    {
        try {
            $handler->handle($request->file('file'));
        } catch (InvalidRatioException $e) {
            return (new JsonResponse(Status::FAILURE))
                ->addNotification(new Error(__('msg.frontend.profile.skin.invalid_ratio')));
        } catch (InvalidResolutionException $e) {
            return (new JsonResponse(Status::FAILURE))
                ->addNotification(new Error(__('msg.frontend.profile.skin.invalid_resolution')));
        } catch (FileException $e) {
            $logger->error($e);

            return (new JsonResponse(Status::FAILURE))
                ->addNotification(new Error(__('msg.request_error')));
        } catch (ForbiddenException $e) {
            return (new JsonResponse(Status::FAILURE))
                ->addNotification(new Error(__('msg.request_error')));
        }

        return (new JsonResponse(Status::SUCCESS))
            ->addNotification(new Success(__('msg.frontend.profile.skin.success')));
    }

    public function uploadCloak(UploadCloakRequest $request, UploadCloakHandler $handler, LoggerInterface $logger): JsonResponse
    {
        try {
            $handler->handle($request->file('file'));
        } catch (InvalidRatioException $e) {
            return (new JsonResponse(Status::FAILURE))
                ->addNotification(new Error(__('msg.frontend.profile.cloak.invalid_ratio')));
        } catch (InvalidResolutionException $e) {
            return (new JsonResponse(Status::FAILURE))
                ->addNotification(new Error(__('msg.frontend.profile.cloak.invalid_resolution')));
        } catch (FileException $e) {
            $logger->error($e);

            return (new JsonResponse(Status::FAILURE))
                ->addNotification(new Error(__('msg.request_error')));
        } catch (ForbiddenException $e) {
            return (new JsonResponse(Status::FAILURE))
                ->addNotification(new Error(__('msg.request_error')));
        }

        return (new JsonResponse(Status::SUCCESS))
            ->addNotification(new Success(__('msg.frontend.profile.cloak.success')));
    }

    public function deleteSkin(DeleteSkinHandler $handler): JsonResponse
    {
        if ($handler->handle()) {
            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Info(__('msg.frontend.profile.skin.delete.success')));
        }

        return (new JsonResponse(Status::FAILURE))
            ->addNotification(new Error(__('msg.frontend.profile.skin.delete.fail')));
    }

    public function deleteCloak(DeleteCloakHandler $handler): JsonResponse
    {
        if ($handler->handle()) {
            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Info(__('msg.frontend.profile.cloak.delete.success')));
        }

        return (new JsonResponse(Status::FAILURE))
            ->addNotification(new Error(__('msg.frontend.profile.cloak.delete.fail')));
    }
}
