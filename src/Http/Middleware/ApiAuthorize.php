<?php
namespace Belt\Core\Http\Middleware;

use Auth, Closure;
use Illuminate\Contracts\Auth\Guard;

/**
 * Class ApiAuthorize
 * @package Belt\Core\Http\Middleware
 */
class ApiAuthorize
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
        $user = $this->auth->user();

        if (!$user) {
            $username = $request->getUser();
            $password = $request->getPassword();
            Auth::attempt(['username' => $username, 'password' => $password]);
            $user = Auth::user();
        }

        if ($user) {
            // if super, then super, permission granted!
            if ($user->hasRole('SUPER') || $user->hasRole('ADMIN')) {
                return $next($request);
            }
        }

        return response('Unauthorized.', 401);
    }

}
