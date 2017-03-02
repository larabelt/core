<?php
namespace Belt\Core\Http\Middleware;

use Auth, Closure;
use Illuminate\Contracts\Auth\Guard;

/**
 * Class OptionalBasicAuth
 * @package Belt\Core\Http\Middleware
 */
class OptionalBasicAuth
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
        if (!$this->auth->user()) {
            $username = $request->getUser();
            $password = $request->getPassword();
            if ($username && $password) {
                Auth::attempt(['username' => $username, 'password' => $password]);
            }
        }

        return $next($request);
    }

}
