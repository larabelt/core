<?php

namespace Belt\Core\Exceptions;

use Exception, Illuminate, Symfony;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;

/**
 * Class Handler
 * @package Belt\Core\Exceptions
 */
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

    /**
     * @var array
     */
    protected $statusCodes = [
        Illuminate\Auth\AuthenticationException::class => 401,
        Illuminate\Auth\Access\AuthorizationException::class => 403,
        Illuminate\Database\Eloquent\ModelNotFoundException::class => 404,
        Illuminate\Validation\ValidationException::class => 422,
        Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class => 404,
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

    /**
     * @param $exception
     * @return int|mixed
     */
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->wantsJson() || $request->expectsJson()) {
            return $this->renderJson($exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * @param Exception $exception
     * @return JsonResponse
     */
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