<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Middleware\AuthenticateOnceWithBasicAuth;
use Belt\Core\Tests\BeltTestCase;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Mockery as m;

class AuthenticateOnceWithBasicAuthTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Middleware\AuthenticateOnceWithBasicAuth::__construct
     * @covers \Belt\Core\Http\Middleware\AuthenticateOnceWithBasicAuth::handle
     * @covers \Belt\Core\Http\Middleware\AuthenticateOnceWithBasicAuth::skip
     * @covers \Belt\Core\Http\Middleware\AuthenticateOnceWithBasicAuth::attempt
     * @covers \Belt\Core\Http\Middleware\AuthenticateOnceWithBasicAuth::answer
     * @covers \Belt\Core\Http\Middleware\AuthenticateOnceWithBasicAuth::credentials
     * @covers \Belt\Core\Http\Middleware\AuthenticateOnceWithBasicAuth::authenticate
     * @covers \Belt\Core\Http\Middleware\AuthenticateOnceWithBasicAuth::prompt
     */
    public function test()
    {

        $next = function ($request) {
            if ($request instanceof Request) {
                return true;
            }
            return false;
        };


        //Auth::shouldReceive('attempt')->once()->andReturn(true);

        $request = new Request();
        $request->headers->set('PHP_AUTH_USER', 'super');
        $request->headers->set('PHP_AUTH_PW', 'secret');

        # prompt
        $guard = m::mock(Guard::class);
        $guard->shouldReceive('getRequest')->andReturn($request);
        $middleware = new AuthenticateOnceWithBasicAuth($guard);
        $response = $middleware->prompt();
        $this->assertEquals(401, $response->getStatusCode());

        # credentials
        $this->assertEquals(['super', 'secret'], $middleware->credentials());

        # authenticate
        Cookie::shouldReceive('queue')->with('basic', json_encode(['super', 'secret']), 86400);
        $middleware->authenticate();

        # answer
        app()['config']->set('session.basic.username', 'super');
        app()['config']->set('session.basic.password', 'secret');
        $this->assertEquals(['super', 'secret'], $middleware->answer());

        # attempt
        $this->assertEquals(true, $middleware->attempt());
        app()['config']->set('session.basic.password', 'new-secret');
        $this->assertEquals(false, $middleware->attempt());

        # skip
        $this->assertEquals(false, $middleware->skip());
        $this->app['request']->cookies->set('basic', json_encode(['super', 'secret']));
        app()['config']->set('session.basic.password', 'secret');
        $this->assertEquals(true, $middleware->skip());
        Auth::shouldReceive('check')->andReturn(true);
        $this->assertEquals(true, $middleware->skip());
        app()['config']->set('session.basic.username', null);
        app()['config']->set('session.basic.password', null);
        $this->assertEquals(true, $middleware->skip());

        # handle 1
        $middleware = m::mock(AuthenticateOnceWithBasicAuth::class . '[skip]', [$guard]);
        $middleware->shouldReceive('skip')->andReturn(true);
        $response = $middleware->handle($request, $next);
        $this->assertEquals(true, $response);

        # handle 2
        $middleware = m::mock(AuthenticateOnceWithBasicAuth::class . '[skip,attempt]', [$guard]);
        $middleware->shouldReceive('skip')->andReturn(false);
        $middleware->shouldReceive('attempt')->andReturn(false);
        $response = $middleware->handle($request, $next);
        $this->assertEquals(401, $response->getStatusCode());

    }

}