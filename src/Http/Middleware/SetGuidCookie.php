<?php namespace Belt\Core\Http\Middleware;

use Closure, Cookie;

/**
 * Class SetGuidCookie
 * @package Belt\Core\Http\Middleware
 */
class SetGuidCookie
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
        if (!Cookie::get('guid')) {
            Cookie::queue(
                Cookie::make('guid', static::generate(), 60 * 24 * 365 * 5, null, null, false, false)
            );
        }

        return $next($request);
    }

    public static function generate()
    {
        mt_srand((double) microtime() * 10000);
        $charid = strtolower(md5(uniqid(rand(), true)));
        $hyphen = chr(45); // "-"
        $guid = substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12);

        return $guid;
    }

}
