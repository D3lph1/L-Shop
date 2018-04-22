<?php
declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Services\Url\Signing\Signed;
use App\Services\Url\Signing\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ValidateSignature
{
    /**
     * @var Validator
     */
    private $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string[]                 $parameters
     *
     * @return mixed
     */
    public function handle($request, \Closure $next, string ...$parameters)
    {
        $resultParameters = [];
        foreach ($parameters as $parameter) {
            $resultParameters[$parameter] = $request->get($parameter);
        }

        $valid = $this->validator->validate(new Signed($request->get('signature'), $resultParameters));
        if (!$valid) {
            return new BadRequestHttpException();
        }

        return $next($request);
    }
}
