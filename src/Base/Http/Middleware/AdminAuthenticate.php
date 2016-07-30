<?php namespace Ohio\Core\Base\Http\Middleware;

use Closure, Session;
use Illuminate\Contracts\Auth\Guard;

class AdminAuthenticate
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
                Session::set('_redirect', $request->fullUrl());
                Session::flash('warning', 'You must be logged in to access that URL.');
                return redirect()->guest('login');
            }
        }

        /* @var $route \Illuminate\Routing\Route */
        $user = $this->auth->user();

        // if super, then super, permission granted!
        if ($user->hasRole('SUPER') || $user->hasRole('ADMIN')) {
            return $next($request);
        }

        $this->auth->logout();
        Session::flash('warning', 'Not Authorized.');

        return redirect()->guest('login');
    }

}
