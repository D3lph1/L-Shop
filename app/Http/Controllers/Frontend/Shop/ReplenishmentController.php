<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Shop;

use App\Handlers\Frontend\Shop\ReplenishmentHandler;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Captcha as CaptchaMiddleware;
use App\Http\Requests\Frontend\Shop\BalanceReplenishmentRequest;
use App\Services\Auth\AccessMode;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use App\Services\Security\Captcha\Captcha;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;
use function App\auth_middleware;

class ReplenishmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(auth_middleware(AccessMode::AUTH));
        $this->middleware(CaptchaMiddleware::NAME)->only('handle');
    }

    public function render(Settings $settings, Captcha $captcha)
    {
        return new JsonResponse(Status::SUCCESS, [
            'captchaKey' => $settings->get('system.security.captcha.enabled')->getValue(DataType::BOOL) ? $captcha->key() : null
        ]);
    }

    public function handle(BalanceReplenishmentRequest $request, ReplenishmentHandler $handler): JsonResponse
    {
        $purchaseId = $handler->handle((float)$request->get('sum'), $request->ip());

        return new JsonResponse(Status::SUCCESS, [
            'purchaseId' => $purchaseId
        ]);
    }
}
