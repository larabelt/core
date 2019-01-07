<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Http\Middleware\SetLocaleFromRequest;
use Belt\Core\Facades\TranslateFacade as Translate;
use Illuminate\Http\Request;

class SetLocaleFromRequestTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Middleware\SetLocaleFromRequest::handle
     */
    public function test()
    {
        $next = function ($request) {
            return $request;
        };

        # handle
        $request = new Request();
        $middleware = new SetLocaleFromRequest();
        Translate::disable();
        $this->assertEquals($next($request), $middleware->handle($request, $next));
    }

    /**
     * @covers \Belt\Core\Http\Middleware\SetLocaleFromRequest::handle
     */
    public function test2()
    {
        $next = function ($request) {
            return $request;
        };

        # handle

        $request = new Request(['locale' => 'es_ES']);
        $middleware = new SetLocaleFromRequest();

        Translate::shouldReceive('isEnabled')->andReturn(true);
        Translate::shouldReceive('getLocaleFromRequest')->with($request)->andReturn('es_ES');
        Translate::shouldReceive('setLocale')->with('es_ES');
        Translate::shouldReceive('getAlternateLocale')->andReturn('es_ES');
        Translate::shouldReceive('setTranslateObjects')->with(true);

        $this->assertEquals($next($request), $middleware->handle($request, $next));
    }

}