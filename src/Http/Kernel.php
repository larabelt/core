<?php
namespace Ohio\Core\Http;

use Illuminate;
use Ohio\Core\Http\Middleware as OhioMiddleware;
use Illuminate\Foundation\Http\Middleware as IlluminateMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        IlluminateMiddleware\CheckForMaintenanceMode::class,
        IlluminateMiddleware\ValidatePostSize::class,
        OhioMiddleware\TrimStrings::class,
        IlluminateMiddleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            OhioMiddleware\EncryptCookies::class,
            Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            Illuminate\Session\Middleware\StartSession::class,
            Illuminate\Session\Middleware\AuthenticateSession::class,
            Illuminate\View\Middleware\ShareErrorsFromSession::class,
            OhioMiddleware\VerifyCsrfToken::class,
            Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => Illuminate\Auth\Middleware\Authorize::class,
        'guest' => OhioMiddleware\RedirectIfAuthenticated::class,
        'throttle' => Illuminate\Routing\Middleware\ThrottleRequests::class,
    ];
}
