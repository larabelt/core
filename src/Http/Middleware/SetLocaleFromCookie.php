<?php namespace Belt\Core\Http\Middleware;

use Belt, Closure, Cookie, Translate;
use Illuminate\Http\Request;

/**
 * Class SetLocaleFromCookie
 * @package Belt\Core\Http\Middleware
 */
class SetLocaleFromCookie
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
        if (!Translate::isEnabled()) {
            return $next($request);
        }

        if ($code = Translate::getLocaleCookie()) {
            if (!Cookie::queued('locale')) {
                Translate::setLocale($code);
                if (Translate::getAlternateLocale()) {
                    Translate::setTranslateObjects(true);
                }
            }
        }

        return $next($request);

//        if (!Translate::isEnabled()) {
//            return $next($request);
//        }
//
//        if ($code = Translate::getLocaleCookie()) {
//            if (!Cookie::queued('locale')) {
//                Translate::setLocale($code);
//                if (Translate::getAlternateLocale()) {
//                    TranslateService::setTranslateObjects(true);
//                }
//            }
//        }
//
//        return $next($request);
    }

}
