<?php

use Mockery as m;
use Ohio\Core\Testing\OhioTestCase;
use Ohio\Core\Exceptions\Handler;
use Ohio\Core\Http\Exceptions\ApiNotFoundHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Session\TokenMismatchException;

class HandlerTest extends OhioTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Core\Exceptions\Handler::render
     * @covers \Ohio\Core\Exceptions\Handler::report
     * @covers \Ohio\Core\Exceptions\Handler::unauthenticated
     */
    public function test()
    {
        $handler = new Handler(app());

        # unauthenticated
        $request = m::mock(Request::class);
        $request->shouldReceive('expectsJson')->andReturn(false);
        $this->assertInstanceOf(RedirectResponse::class, $handler->unauthenticated($request, new AuthenticationException()));
        $request = m::mock(Request::class);
        $request->shouldReceive('expectsJson')->andReturn(true);
        $this->assertInstanceOf(JsonResponse::class, $handler->unauthenticated($request, new AuthenticationException()));

        # default report
        $this->assertNull($handler->report(new TokenMismatchException()));

        # Default Handler instead...
        $this->assertNull($handler->render(new Request(), new \Exception()));

        # ApiException
        $this->assertNotNull($handler->render(new Request(), new ApiNotFoundHttpException()));

        # $request->ajax() == true
        $request = $this->getMockBuilder(Request::class)
            ->setMethods(['ajax'])
            ->getMock();
        $request->expects($this->once())->method('ajax')->willReturn(true);
        $this->assertNotNull($handler->render($request, new \Exception()));

        # $request->wantsJson() == true
        $request = $this->getMockBuilder(Request::class)
            ->setMethods(['wantsJson'])
            ->getMock();
        $request->expects($this->once())->method('wantsJson')->willReturn(true);
        $this->assertNotNull($handler->render($request, new \Exception()));

        # JsonReponse loaded exception
        $exception = $this->getMockBuilder(\Exception::class)
            ->setMethods(['getResponse'])
            ->getMock();
        $exception->expects($this->once())->method('getResponse')->willReturn(new JsonResponse('data', 200));
        $this->assertNotNull($handler->render(new Request(), $exception));

    }

}
