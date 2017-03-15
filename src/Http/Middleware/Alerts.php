<?php namespace Belt\Core\Http\Middleware;

use Closure;
use Belt\Content\Alert;

/**
 * Class RequestInjections
 * @package Belt\Core\Http\Middleware
 */
class Alerts
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
//        s('alerts');
//        $alerts = Alert::active()->get();
//        s($alerts->pluck('id')->all());

//        $keys = array_slice(func_get_args(), 2);
//
//        foreach ($keys as $key) {
//            $value = $request->route()->parameter($key);
//            $request->request->set($key, $value);
//        }

        return $next($request);
    }

}
