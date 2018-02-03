<?php
declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Services\Infrastructure\Notification\Notifications\Danger;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Security\Captcha\Captcha as CaptchaInterface;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;

class Captcha
{
    public const REQUEST_PARAM_NAME = '_captcha';

    /**
     * @var CaptchaInterface
     */
    private $captcha;

    /**
     * @var Repository
     */
    private $config;

    public function __construct(CaptchaInterface $captcha, Repository $config)
    {
        $this->captcha = $captcha;
        $this->config = $config;
    }

    public function handle(Request $request, \Closure $next)
    {
        $env = $this->config->get('app.env');
        if ($env === 'testing' || $env === 'dev') {
            return $next($request);
        }

        $code = $request->get(self::REQUEST_PARAM_NAME);
        if (empty($code)) {
            return $this->response();
        }
        if ($this->captcha->verify($code, $request->ip())) {
            return $next($request);
        }

        return $this->response();
    }

    private function response()
    {
        return response()->json(
            (new JsonResponse('invalid_captcha'))
                ->addNotification(new Danger(__('msg.captcha_required')))
        );
    }
}
