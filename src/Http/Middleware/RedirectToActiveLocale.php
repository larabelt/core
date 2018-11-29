<?php namespace Belt\Core\Http\Middleware;

use Belt, Closure;
use Belt\Core\Behaviors;
use Illuminate\Http\Request;

/**
 * Class RedirectToActiveLocale
 * @package Belt\Core\Http\Middleware
 */
class RedirectToActiveLocale extends Belt\Core\Http\Middleware\BaseLocaleMiddleware
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

        if (!$this->service()->isEnabled()) {
            return $next($request);
        };

        if ($code = $this->service()->getLocaleFromRequest($request)) {
            return $next($request);
        }

        $code = $this->service()->getLocaleCookie() ?: $this->service()->getLocale();

        $uri = $request->server->get('REQUEST_URI');

        $newUri = sprintf('/%s%s', $code, $uri);;

        return redirect($newUri);
    }

}
