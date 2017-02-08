<?php

namespace Ohio\Core\Exceptions;

use Exception, Illuminate, Symfony;
use Ohio\Core\Http\Exceptions\ApiException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        Illuminate\Auth\AuthenticationException::class,
        Illuminate\Auth\Access\AuthorizationException::class,
        Symfony\Component\HttpKernel\Exception\HttpException::class,
        Illuminate\Database\Eloquent\ModelNotFoundException::class,
        Illuminate\Session\TokenMismatchException::class,
        Illuminate\Validation\ValidationException::class,
    ];

    protected $statusCodes = [
        Illuminate\Auth\AuthenticationException::class => 401,
        Illuminate\Auth\Access\AuthorizationException::class => 403,
        Illuminate\Database\Eloquent\ModelNotFoundException::class => 404,
        Illuminate\Validation\ValidationException::class => 422,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    public function getStatusCode($exception)
    {

        $statusCode = 200;
        $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : $statusCode;
        $statusCode = array_get($this->statusCodes, get_class($exception), $statusCode);

        return $statusCode;
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        if ($request->wantsJson()) {
            return $this->renderJson($exception);
        }

        parent::render($request, $exception);
    }

    public function renderJson(Exception $exception)
    {

        $message = $exception->getMessage();

        if (method_exists($exception, 'getMsg')) {
            $message = $exception->getMsg();
        }

        if (method_exists($exception, 'getResponse')) {
            $response = $exception->getResponse();
            if ($response instanceof JsonResponse) {
                $message = $response->getData();
            }
        }

        return response()->json($message, $this->getStatusCode($exception));
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  Illuminate\Http\Request $request
     * @param  Illuminate\Auth\AuthenticationException $exception
     * @return Illuminate\Http\Response
     */
    public function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}