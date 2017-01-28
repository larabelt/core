<?php

use Mockery as m;
use Ohio\Core\Testing\OhioTestCase;
use Ohio\Core\Http\Middleware\ApiAuthorize;
use Ohio\Core\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;

class ApiAuthorizeTest extends OhioTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Core\Http\Middleware\ApiAuthorize::__construct()
     * @covers \Ohio\Core\Http\Middleware\ApiAuthorize::handle()
     */
    public function test()
    {

        $next = function ($request) {
            if ($request instanceof Request) {
                return true;
            }
            return false;
        };

        # user already logged in
        $user = m::mock(User::class);
        $user->shouldReceive('hasRole')->andReturn(true);
        $guard = m::mock(Guard::class);
        $guard->shouldReceive('user')->andReturn($user);
        $middleware = new ApiAuthorize($guard);
        $response = $middleware->handle(new Request(), $next);
        $this->assertTrue($response);

        # request without credentials
        $guard = m::mock(Guard::class);
        $guard->shouldReceive('user')->andReturn(null);
        $middleware = new ApiAuthorize($guard);
        $response = $middleware->handle(new Request(), $next);
        $this->assertEquals(401, $response->getStatusCode());
    }

}