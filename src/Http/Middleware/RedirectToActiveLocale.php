<?php namespace Belt\Core\Http\Middleware;

use Belt, Closure, Translate;
use Belt\Core\Behaviors;
use Illuminate\Http\Request;

/**
 * Class RedirectToActiveLocale
 * @package Belt\Core\Http\Middleware
 */
class RedirectToActiveLocale
{
    use Behaviors\CanEnable;

    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle(Request $request, Closure $next)
    {
        //return $next($request);

        if (!RedirectToActiveLocale::isEnabled()) {
            return $next($request);
        };

        if (!Translate::isEnabled()) {
            return $next($request);
        };

        if ($request->method() != 'GET') {
            return $next($request);
        }

        if ($code = Translate::getLocaleFromRequest($request)) {
            return $next($request);
        }

        $code = Translate::getLocaleCookie() ?: Translate::getLocale();

        $uri = $request->server->get('REQUEST_URI');

        $newUri = sprintf('/%s%s', $code, $uri);;

        return redirect($newUri);
    }

}
