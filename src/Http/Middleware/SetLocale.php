<?php namespace Belt\Core\Http\Middleware;

use Closure, Cookie;
use Belt\Core\Services\TranslateService;

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
        $locale = $request->get('locale') ?: $request->cookie('locale');

        if ($locale) {
            $this->service()->setLocale($locale);
            Cookie::queue(Cookie::make('locale', $locale, 86400 * 365, null, null, false, false));

        }

        return $next($request);
    }

}
