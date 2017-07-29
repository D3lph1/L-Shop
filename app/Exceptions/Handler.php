<?php

namespace App\Exceptions;

use App\Exceptions\Payment\InvalidRequestDataException;
use App\Exceptions\User\BannedException;
use App\Exceptions\User\EmailAlreadyExistsException;
use App\Exceptions\User\NotFoundException;
use App\Exceptions\User\RemindCodeNotFound;
use App\Exceptions\User\UsernameAlreadyExistsException;
use App\Services\Message;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
        UsernameAlreadyExistsException::class,
        EmailAlreadyExistsException::class,
        InvalidRequestDataException::class,
        NotFoundException::class,
        RemindCodeNotFound::class,
        BannedException::class
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof BannedException) {
            return $this->ban($exception);
        }

        if (!$this->isHttpException($exception) and !config('app.debug')) {
            $exception = new HttpException(500);
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }

    /**
     * @param BannedException $e
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function ban(BannedException $e)
    {
        $until = $e->getUntil();
        $reason = $e->getReason();
        $this->container->make(Message::class)->danger(build_ban_message($until, $reason));

        return redirect()->route('index');
    }
}
