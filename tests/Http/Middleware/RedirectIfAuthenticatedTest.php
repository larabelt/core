<?php

use Mockery as m;
use Ohio\Core\Testing\OhioTestCase;
use Ohio\Core\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;

class RedirectIfAuthenticatedTest extends OhioTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Core\Http\Middleware\RedirectIfAuthenticated::handle()
     */
    public function test1()
    {

        $next = function ($request) {
            if ($request instanceof Request) {
                return true;
            }
            return false;
        };

        # go to /home if auth check is true
        $guard = m::mock(Guard::class);
        $guard->shouldReceive('check')->andReturn(false);
        Auth::shouldReceive('guard')->andReturn($guard);
        $middleware = new RedirectIfAuthenticated();
        $response = $middleware->handle(new Request(), $next, $guard);
        $this->assertTrue($response);
    }

    /**
     * @covers \Ohio\Core\Http\Middleware\RedirectIfAuthenticated::handle()
     */
    public function test2()
    {

        $next = function ($request) {
            if ($request instanceof Request) {
                return true;
            }
            return false;
        };

        # go to $next($response) otherwise
        $guard = m::mock(Guard::class);
        $guard->shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('guard')->andReturn($guard);
        $middleware = new RedirectIfAuthenticated();
        $response = $middleware->handle(new Request(), $next, $guard);
        $this->isInstanceOf(RedirectResponse::class, $response);
    }

}