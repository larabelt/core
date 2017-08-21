<?php

namespace Belt\Core\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Class GuestUser
 * @package Belt\Core\Http\Middleware
 */
class GuestUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if (!Auth::guard($guard)->check()) {
            Auth::setUser($this->getGuestUserObject());
        }

        return $next($request);
    }

    public function getGuestUserObject()
    {
        $userClass = config('auth.providers.users.model');

        return new $userClass();
    }
}
