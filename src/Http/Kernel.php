<?php

namespace Belt\Core\Http;

use Illuminate;
use Belt\Core\Http\Middleware as BeltMiddleware;
use Illuminate\Foundation\Http\Middleware as IlluminateMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

/**
 * Class Kernel
 * @package Belt\Core\Http
 */
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
        BeltMiddleware\TrimStrings::class,
        IlluminateMiddleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'admin' => [
            Illuminate\Auth\Middleware\Authenticate::class,
            BeltMiddleware\ActiveTeam::class,
            BeltMiddleware\AdminAuthorize::class,
        ],
        'api' => [
            BeltMiddleware\EncryptCookies::class,
            Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            Illuminate\Session\Middleware\StartSession::class,
            Illuminate\Session\Middleware\AuthenticateSession::class,
            BeltMiddleware\OptionalBasicAuth::class,
            BeltMiddleware\ActiveTeam::class,
            BeltMiddleware\AdminAuthorize::class,
            BeltMiddleware\GuestUser::class,
            'throttle:60,1',
            'request.replacements',
            'bindings',
        ],
        'web' => [
            BeltMiddleware\EncryptCookies::class,
            Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            BeltMiddleware\SetGuidCookie::class,
            Illuminate\Session\Middleware\StartSession::class,
            Illuminate\Session\Middleware\AuthenticateSession::class,
            Illuminate\View\Middleware\ShareErrorsFromSession::class,
            BeltMiddleware\VerifyCsrfToken::class,
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
        'cors' => \Barryvdh\Cors\HandleCors::class,
        'guest' => BeltMiddleware\RedirectIfAuthenticated::class,
        'request.replacements' => BeltMiddleware\RequestReplacements::class,
        'request.injections' => BeltMiddleware\RequestInjections::class,
        'throttle' => Illuminate\Routing\Middleware\ThrottleRequests::class,
    ];
}
