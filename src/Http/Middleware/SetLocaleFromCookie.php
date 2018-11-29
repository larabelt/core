<?php namespace Belt\Core\Http\Middleware;

use Belt, Closure, Cookie;
use Belt\Core\Services\TranslateService;
use Illuminate\Http\Request;

/**
 * Class SetLocaleFromCookie
 * @package Belt\Core\Http\Middleware
 */
class SetLocaleFromCookie extends Belt\Core\Http\Middleware\BaseLocaleMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        if (!$this->service()->isEnabled()) {
            return $next($request);
        }

        if ($code = $this->service()->getLocaleCookie()) {
            if (!Cookie::queued('locale')) {
                TranslateService::setTranslateObjects(true);
                $this->service()->setLocale($code);
            }
        }

        return $next($request);
    }

}
