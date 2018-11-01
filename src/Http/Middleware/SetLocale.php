<?php namespace Belt\Core\Http\Middleware;

use Closure, Cookie;
use Belt\Core\Services\TranslateService;
use Illuminate\Http\Request;

/**
 * Class SetLocale
 * @package Belt\Core\Http\Middleware
 */
class SetLocale
{

    /**
     * @var TranslateService
     */
    public $service;

    /**
     * @return TranslateService
     */
    public function service()
    {
        return $this->service ?: $this->service = new TranslateService();
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
        if (!$this->service()->isEnabled()) {
            return $next($request);
        }

        $code = $this->service()->getLocaleFromRequest($request);

        if ($code) {

            $this->service()->setLocale($code);

            if ($this->service()->getAlternateLocale()) {
                TranslateService::setTranslateObjects(true);
            }

            $uri = $request->server->get('REQUEST_URI');
            foreach (config('belt.core.translate.locales') as $locale) {
                $prefix = sprintf('/%s', $locale['code']);
                if (substr($uri, 0, strlen($prefix)) == $prefix) {
                    $newUri = substr($uri, strlen($prefix));
                }
            }

            if (isset($newUri)) {

                $request->server->set('REQUEST_URI', $newUri);

                $newRequest = new Request();
                $newRequest->initialize(
                    $request->query->all(),
                    $request->request->all(),
                    $request->attributes->all(),
                    $request->cookies->all(),
                    $request->files->all(),
                    $request->server->all(),
                    $request->getContent()
                );

                return $next($newRequest);
            }

        }

        return $next($request);
    }

}
