<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Middleware\RequestReplacements;
use Tests\Belt\Core;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Mockery as m;
use Symfony\Component\HttpFoundation\ParameterBag;

class RequestReplacementsTest extends \Tests\Belt\Core\BeltTestCase
{

    use \Tests\Belt\Core\Base\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Middleware\RequestReplacements::__construct()
     * @covers \Belt\Core\Http\Middleware\RequestReplacements::handle()
     * @covers \Belt\Core\Http\Middleware\RequestReplacements::replacements()
     * @covers \Belt\Core\Http\Middleware\RequestReplacements::replace()
     */
    public function test()
    {

        $next = function ($request) {
            return $request;
        };

        # construct
        $guard = m::mock(Guard::class);
        $guard->shouldReceive('id')->andReturn(1);
        $middleware = new RequestReplacements($guard);

        # replacements
        $replacements = $middleware->replacements();
        $this->assertEquals(1, array_get($replacements, '[auth.id]'));

        # handle
        $requestParameterBag = new ParameterBag(['bar' => '[auth.id]']);
        $queryParameterBag = new ParameterBag([
            'foo' => '[auth.id]',
            'something' => 'else',
            'object' => $this->getUploadFile(__FILE__),
        ]);
        $routeParameterBag = new ParameterBag(['id' => '[auth.id]']);

        $route = m::mock(Route::class);
        $route->shouldReceive('parameters')->once()->andReturn($routeParameterBag);
        $route->shouldReceive('setParameter')->with('id', 1)->andReturnSelf();

        $request = m::mock(Request::class);
        $request->query = $queryParameterBag;
        $request->request = $requestParameterBag;
        $request->shouldReceive('route')->andReturn($route);

        $request = $middleware->handle($request, $next);
        $this->assertEquals(1, $request->query->get('foo'));
        $this->assertEquals(1, $request->request->get('bar'));
    }

}