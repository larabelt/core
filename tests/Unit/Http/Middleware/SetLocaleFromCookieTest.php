<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Facades\TranslateFacade as Translate;
use Belt\Core\Http\Middleware\SetLocaleFromCookie;
use Belt\Core\Tests;
use Illuminate\Http\Request;
use Mockery as m;

class SetLocaleFromCookieTest extends Tests\BeltTestCase
{

    use Tests\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Middleware\SetLocaleFromCookie::handle
     */
    public function test()
    {
        $next = function ($request) {
            return $request;
        };

        # handle
        $request = new Request();
        $middleware = new SetLocaleFromCookie();
        Translate::disable();
        $this->assertEquals($next($request), $middleware->handle($request, $next));
    }

    /**
     * @covers \Belt\Core\Http\Middleware\SetLocaleFromCookie::handle
     */
    public function test2()
    {
        $next = function ($request) {
            return $request;
        };

        # handle
        $request = new Request(['locale' => 'es_ES']);

        $middleware = new SetLocaleFromCookie();

        Translate::shouldReceive('isEnabled')->andReturn(true);
        Translate::shouldReceive('getLocaleCookie')->andReturn('es_ES');
        Translate::shouldReceive('setLocale')->with('es_ES');
        Translate::shouldReceive('getAlternateLocale')->andReturn('es_ES');
        Translate::shouldReceive('setTranslateObjects')->with(true);

        $this->app['request']->cookies->set('locale', null);

        $this->assertEquals($next($request), $middleware->handle($request, $next));
    }

}