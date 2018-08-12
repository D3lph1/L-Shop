<?php
declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Services\Notification\Notifications\Warning;
use App\Services\Response\JsonResponse;
use App\Services\Security\Captcha\Captcha as CaptchaInterface;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;

class Captcha
{
    public const NAME = 'captcha';

    public const REQUEST_PARAM_NAME = '_captcha';

    /**
     * @var CaptchaInterface
     */
    private $captcha;

    /**
     * @var Repository
     */
    private $config;

    /**
     * @var Settings
     */
    private $settings;

    public function __construct(CaptchaInterface $captcha, Repository $config, Settings $settings)
    {
        $this->captcha = $captcha;
        $this->config = $config;
        $this->settings = $settings;
    }

    public function handle(Request $request, \Closure $next)
    {
        $env = $this->config->get('app.env');
        if ($env === 'testing' ||
            $env === 'dev' ||
            !$this->settings->get('system.security.captcha.enabled')->getValue(DataType::BOOL)
        ) {
            return $next($request);
        }

        $code = $request->get(self::REQUEST_PARAM_NAME);
        if (empty($code)) {
            return $this->response();
        }
        if (!$this->captcha->verify($code, $request->ip())) {
            return $this->response();
        }

        return $next($request);
    }

    private function response()
    {
        return response()->json(
            (new JsonResponse('invalid_captcha'))
                ->addNotification(new Warning(__('msg.captcha_required')))
        );
    }
}
