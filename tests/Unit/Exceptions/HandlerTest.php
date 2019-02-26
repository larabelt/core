<?php namespace Tests\Belt\Core\Unit\Exceptions;

use Belt\Core\Exceptions\Handler;
use Belt\Core\Http\Exceptions\ApiNotFoundHttpException;
use Tests\Belt\Core\BeltTestCase;
use Illuminate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Mockery as m;

class HandlerTest extends BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Exceptions\Handler::render
     * @covers \Belt\Core\Exceptions\Handler::report
     * @covers \Belt\Core\Exceptions\Handler::unauthenticated
     * @covers \Belt\Core\Exceptions\Handler::getStatusCode
     * @covers \Belt\Core\Exceptions\Handler::renderJson
     */
    public function test()
    {
        $request = new Request();
        $request->headers->set('Accept', 'application/json');

        $handler = new Handler(app());

        # unauthenticated
        $this->assertInstanceOf(RedirectResponse::class, $handler->unauthenticated(new Request(), new AuthenticationException()));
        $this->assertInstanceOf(JsonResponse::class, $handler->unauthenticated($request, new AuthenticationException()));

        # default report
        $this->assertNull($handler->report(new AuthorizationException()));

        # default render
        $this->assertInstanceOf(Illuminate\Http\Response::class, $handler->render(new Request(), new \Exception()));

        # status codes
        $this->assertEquals(200, $handler->getStatusCode(new \Exception()));
        $this->assertEquals(403, $handler->getStatusCode(new AuthorizationException()));
        $this->assertEquals(404, $handler->getStatusCode(new ApiNotFoundHttpException()));

        # renderJson (normal)
        $response = $handler->render($request, new \Exception('test1'));
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('test1', $response->getData());

        # renderJson (getMsg)
        $exception = new ApiNotFoundHttpException();
        $exception->setMsg('test2');
        $response = $handler->render($request, $exception);
        $this->assertEquals('test2', $response->getData());
        $this->assertEquals(404, $response->getStatusCode());

        # renderJson (getResponse)
        $validatorFactory = app('Illuminate\Validation\Factory');
        $validator = $validatorFactory->make([], ['foo' => 'required']);
        $exception = new ValidationException($validator, new JsonResponse('test3'));
        $response = $handler->render($request, $exception);
        $this->assertEquals('test3', $response->getData());

    }

}
