<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Http\Middleware\SetGuidCookie;
use Illuminate\Http\Request;

class SetGuidCookieTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

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