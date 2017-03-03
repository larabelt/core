<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Http\Middleware\OptionalBasicAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;

class OptionalBasicAuthTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Middleware\OptionalBasicAuth::__construct()
     * @covers \Belt\Core\Http\Middleware\OptionalBasicAuth::handle()
     */
    public function test()
    {

        $next = function ($request) {
            if ($request instanceof Request) {
                return true;
            }
            return false;
        };

        Auth::shouldReceive('attempt')->once()->andReturn(true);

        $request = new Request();
        $request->headers->set('PHP_AUTH_USER', 'user');
        $request->headers->set('PHP_AUTH_PW', 'pass');

        # request without credentials
        $guard = m::mock(Guard::class);
        $guard->shouldReceive('user')->andReturn(null);
        $middleware = new OptionalBasicAuth($guard);
        $response = $middleware->handle($request, $next);
        $this->assertTrue($response);
    }

}