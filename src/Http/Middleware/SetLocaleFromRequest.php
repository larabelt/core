<?php namespace Belt\Core\Http\Middleware;

use Belt, Closure, Translate;
use Illuminate\Http\Request;

/**
 * Class SetLocaleFromRequest
 * @package Belt\Core\Http\Middleware
 */
class SetLocaleFromRequest
{

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
        if (!Translate::isEnabled()) {
            return $next($request);
        }

        $code = Translate::getLocaleFromRequest($request);

        if ($code) {

            Translate::setLocale($code);

            if (Translate::getAlternateLocale()) {
                Translate::setTranslateObjects(true);
            }

        }

        return $next($request);

//        if (!Translate::isEnabled()) {
//            return $next($request);
//        }
//
//        $code = Translate::getLocaleFromRequest($request);
//
//        if ($code) {
//
//            Translate::setLocale($code);
//
//            if (Translate::getAlternateLocale()) {
//                TranslateService::setTranslateObjects(true);
//            }
//
//        }
//
//        return $next($request);
    }

}
