<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Middleware\GuestUser;
use Belt\Core\Tests\BeltTestCase;
use Belt\Core\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery as m;

class GuestUserTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Middleware\GuestUser::getGuestUserObject
     * @covers \Belt\Core\Http\Middleware\GuestUser::handle
     */
    public function test()
    {

        app()['config']->set('auth.providers.users.model', User::class);

        # getGuestUserObject
        $this->assertInstanceOf(User::class, (new GuestUser())->getGuestUserObject());

        # handle
        $request = m::mock(Request::class);
        $next = function ($request) {
            if ($request instanceof Request) {
                return true;
            }
            return false;
        };
        $guard = m::mock(Guard::class);
        $guard->shouldReceive('check')->andReturn(false);
        $guestUser = new User();
        Auth::shouldReceive('guard')->with($guard)->andReturn($guard);
        Auth::shouldReceive('setUser')->with($guestUser)->andReturnSelf();
        $middleware = m::mock(GuestUser::class . '[getGuestUserObject]');
        $middleware->shouldReceive('getGuestUserObject')->andReturn($guestUser);
        $middleware->handle($request, $next, $guard);

    }

}