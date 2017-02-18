<?php namespace Belt\Core\Http\Middleware;

use Closure;

/**
 * Class RequestInjections
 * @package Belt\Core\Http\Middleware
 */
class RequestInjections
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $keys = array_slice(func_get_args(), 2);

        foreach ($keys as $key) {
            $value = $request->route()->parameter($key);
            $request->request->set($key, $value);
        }

        return $next($request);
    }

}
