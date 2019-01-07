<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Http\Middleware\SetLocaleFromCookie;
use Belt\Core\Facades\TranslateFacade as Translate;
use Illuminate\Http\Request;

class SetLocaleFromCookieTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

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