<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Middleware\SetGuidCookie;
use Belt\Core\Tests;
use Illuminate\Http\Request;
use Mockery as m;

class SetGuidCookieTest extends Tests\BeltTestCase
{

    use Tests\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Middleware\SetGuidCookie::handle()
     * @covers \Belt\Core\Http\Middleware\SetGuidCookie::generate()
     */
    public function test()
    {

        $next = function ($request) {
            return $request;
        };

        # generate
        $this->assertEquals(36, strlen(SetGuidCookie::generate()));

        /**
         * @todo test Cookies better.
         */
        # handle
        $middleware = new SetGuidCookie();
        $request = new Request();
        $middleware->handle($request, $next);
    }

}