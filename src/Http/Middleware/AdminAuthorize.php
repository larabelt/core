<?php namespace Belt\Core\Http\Middleware;

use Belt, Closure, Session, View;
use Illuminate\Contracts\Auth\Guard;

/**
 * Class AdminAuthorize
 * @package Belt\Core\Http\Middleware
 */
class AdminAuthorize
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                Session::put('_redirect', $request->fullUrl());
                Session::flash('warning', 'You must be logged in to access that URL.');
                return redirect()->guest('login');
            }
        }

        /* @var $route \Illuminate\Routing\Route */
        $user = $this->auth->user();

        // if admin-user or a team user, permission granted!
        if ($user->can('admin-dashboard') || $user->teams->count()) {
            View::share('auth', $user);
            return $next($request);
        }

        $this->auth->logout();
        Session::flash('warning', 'Not Authorized.');

        return redirect()->guest('login');
    }

}
