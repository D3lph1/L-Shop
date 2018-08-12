<?php
declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Services\Url\Signing\Signed;
use App\Services\Url\Signing\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ValidateSignature
{
    public const SIGNATURE_REQUEST_PARAM = 'signature';

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
        if (!$request->has(self::SIGNATURE_REQUEST_PARAM)) {
            throw new BadRequestHttpException(
                'Parameter with name "' . self::SIGNATURE_REQUEST_PARAM . '" does not exist in the request'
            );
        }

        $resultParameters = [];
        foreach ($parameters as $parameter) {
            $resultParameters[$parameter] = $request->get($parameter);
        }

        $valid = $this->validator->validate(new Signed($request->get(self::SIGNATURE_REQUEST_PARAM), $resultParameters));
        if (!$valid) {
            throw new BadRequestHttpException('The request has an invalid signature');
        }

        return $next($request);
    }
}
