<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\Profile;

use App\Exceptions\ForbiddenException;
use App\Exceptions\Media\Character\InvalidRatioException;
use App\Exceptions\Media\Character\InvalidResolutionException;
use App\Handlers\Frontend\Profile\Character\UploadCloakHandler;
use App\Handlers\Frontend\Profile\Character\UploadSkinHandler;
use App\Handlers\Frontend\Profile\Character\VisitHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Profile\Character\UploadCloakRequest;
use App\Http\Requests\Frontend\Profile\Character\UploadSkinRequest;
use App\Services\Auth\Auth;
use App\Services\Infrastructure\Notification\Notifications\Error;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use App\Services\Media\Image;
use App\Services\Settings\Settings;
use Illuminate\Contracts\View\View;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CharacterController extends Controller
{
    public function render(Auth $auth, Settings $settings, VisitHandler $handler): View
    {
        $dto = $handler->handle();

        return view('frontend.profile.character', [
            'username' => $auth->getUser()->getUsername(),
            'skinEnabled' => $settings->get('system.profile.character.skin.enabled')->getValue(),
            'maxSkinFileSize' => $settings->get('system.profile.character.skin.max_file_size')->getValue(),

            'availableSkinImageSizes' => $dto->getAvailableSkinImageSizes(),

            'hdSkinEnabled' => $settings->get('system.profile.character.skin.hd.enabled')->getValue(),
            'cloakEnabled' => $settings->get('system.profile.character.cloak.enabled')->getValue(),
            'maxCloakFileSize' => $settings->get('system.profile.character.cloak.max_file_size')->getValue(),
            'availableCloakImageSizes' => $dto->getAvailableCloakImageSizes(),
            'hdCloakEnabled' => $settings->get('system.profile.character.cloak.hd.enabled')->getValue(),
            'cloakExist' => Image::cloakPath($auth->getUser()->getUsername()) !== null
        ]);
    }

    public function uploadSkin(UploadSkinRequest $request, UploadSkinHandler $handler, LoggerInterface $logger): JsonResponse
    {
        try {
            $handler->handle($request->file('skin'));
        } catch (InvalidRatioException $e) {
            return (new JsonResponse(Status::FAILURE))
                ->addNotification(new Error(__('msg.profile.character.skin.invalid_ratio')));
        } catch (InvalidResolutionException $e) {
            return (new JsonResponse(Status::FAILURE))
                ->addNotification(new Error(__('msg.profile.character.skin.invalid_resolution')));
        } catch (FileException $e) {
            $logger->error($e);

            return (new JsonResponse(Status::FAILURE))
                ->addNotification(new Error(__('msg.request_error')));
        } catch (ForbiddenException $e) {
            return (new JsonResponse(Status::FAILURE))
                ->addNotification(new Error(__('msg.request_error')));
        }

        return (new JsonResponse(Status::SUCCESS))
            ->addNotification(new Success(__('msg.profile.character.skin.success')));
    }

    public function uploadCloak(UploadCloakRequest $request, UploadCloakHandler $handler, LoggerInterface $logger): JsonResponse
    {
        try {
            $handler->handle($request->file('cloak'));
        } catch (InvalidRatioException $e) {
            return (new JsonResponse(Status::FAILURE))
                ->addNotification(new Error(__('msg.profile.character.cloak.invalid_ratio')));
        } catch (InvalidResolutionException $e) {
            return (new JsonResponse(Status::FAILURE))
                ->addNotification(new Error(__('msg.profile.character.cloak.invalid_resolution')));
        } catch (FileException $e) {
            $logger->error($e);

            return (new JsonResponse(Status::FAILURE))
                ->addNotification(new Error(__('msg.request_error')));
        } catch (ForbiddenException $e) {
            return (new JsonResponse(Status::FAILURE))
                ->addNotification(new Error(__('msg.request_error')));
        }

        return (new JsonResponse(Status::SUCCESS))
            ->addNotification(new Success(__('msg.profile.character.cloak.success')));
    }
}
