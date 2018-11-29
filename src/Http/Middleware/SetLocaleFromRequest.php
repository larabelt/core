<?php namespace Belt\Core\Http\Middleware;

use Belt, Closure;
use Belt\Core\Services\TranslateService;
use Illuminate\Http\Request;

/**
 * Class SetLocaleFromRequest
 * @package Belt\Core\Http\Middleware
 */
class SetLocaleFromRequest extends Belt\Core\Http\Middleware\BaseLocaleMiddleware
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
        if (!$this->service()->isEnabled()) {
            return $next($request);
        }

        $code = $this->service()->getLocaleFromRequest($request);

        if ($code) {

            $this->service()->setLocale($code);

            if ($this->service()->getAlternateLocale()) {
                TranslateService::setTranslateObjects(true);
            }

            if ($this->service()->prefixUrls()) {

                $uri = $request->server->get('REQUEST_URI');

                foreach ($this->service()->getAvailableLocales() as $locale) {
                    $prefix = sprintf('/%s', $locale['code']);
                    if (substr($uri, 0, strlen($prefix)) == $prefix) {
                        $newUri = substr($uri, strlen($prefix));
                    }
                }

                if (isset($newUri)) {

                    $request->server->set('REQUEST_URI', $newUri);

                    Belt\Core\Http\Middleware\RedirectToActiveLocale::disable();

                    $newRequest = $request->duplicate(
                        $request->query->all(),
                        $request->request->all(),
                        $request->attributes->all(),
                        $request->cookies->all(),
                        $request->files->all(),
                        $request->server->all()
                    );

                    //return $next($newRequest);
                    return \Route::dispatchToRoute($newRequest);
                }

            }

        }

        return $next($request);
    }

}
