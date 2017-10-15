<?php
declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Facades\ReCaptcha;
use App\Services\Message;
use Closure;
use Illuminate\Contracts\Container\Container;

/**
 * Class Captcha
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Middleware
 */
class Captcha
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('app.debug') === true) {
            return $next($request);
        }

        $reCaptchaResponse = $request->get('g-recaptcha-response');
        if (!$reCaptchaResponse) {
            $reCaptchaResponse = $request->get('captcha');
        }

        if (ReCaptcha::verify($reCaptchaResponse, $request->ip())) {
            return $next($request);
        }

        if ($request->ajax()) {
            return json_response('invalid captcha');
        }
        $this->container->make(Message::class)->danger(__('messages.captcha_required'));

        return back();
    }
}
