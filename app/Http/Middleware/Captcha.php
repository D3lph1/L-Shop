<?php

namespace App\Http\Middleware;

use App\Facades\ReCaptcha;
use Closure;

/**
 * Class Captcha
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Middleware
 */
class Captcha
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
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
        \Message::danger('Вы должны подтвердить то, что не являетесь роботом');

        return back();
    }
}
