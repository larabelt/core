<?php

use Ohio\Core\Base\Testing\OhioTestCase;
use Ohio\Core\Base\Exceptions\Handler;
use Ohio\Core\Base\Http\Exceptions\ApiNotFoundHttpException;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HandlerTest extends OhioTestCase
{

    /**
     * @covers \Ohio\Core\Base\Exceptions\Handler::render
     */
    public function test()
    {

        # Default Handler instead...
        $this->assertNull(Handler::render(new Request(), new \Exception()));

        # ApiException
        $this->assertNotNull(Handler::render(new Request(), new ApiNotFoundHttpException()));

        # $request->ajax() == true
        $request = $this->getMockBuilder(Request::class)
            ->setMethods(['ajax'])
            ->getMock();
        $request->expects($this->once())->method('ajax')->willReturn(true);
        $this->assertNotNull(Handler::render($request, new \Exception()));

        # $request->wantsJson() == true
        $request = $this->getMockBuilder(Request::class)
            ->setMethods(['wantsJson'])
            ->getMock();
        $request->expects($this->once())->method('wantsJson')->willReturn(true);
        $this->assertNotNull(Handler::render($request, new \Exception()));

        # JsonReponse loaded exception
        $exception = $this->getMockBuilder(\Exception::class)
            ->setMethods(['getResponse'])
            ->getMock();
        $exception->expects($this->once())->method('getResponse')->willReturn(new JsonResponse('data', 200));
        $this->assertNotNull(Handler::render(new Request(), $exception));

    }

}
