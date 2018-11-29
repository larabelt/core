<?php namespace Belt\Core\Http\Middleware;

use Closure, Cookie;
use Belt\Core\Services\TranslateService;
use Illuminate\Http\Request;

/**
 * Class PersistLocaleViaCookie
 * @package Belt\Core\Http\Middleware
 */
class SetLocaleFromCookie
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

        if ($code = $this->service()->getLocaleCookie()) {
            if (!Cookie::queued('locale')) {
                TranslateService::setTranslateObjects(true);
                $this->service()->setLocale($code);
            }
        }

        return $next($request);
    }

}
