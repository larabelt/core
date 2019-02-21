<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Middleware\RequestInjections;
use Belt\Core\Tests\BeltTestCase;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Mockery as m;
use Symfony\Component\HttpFoundation\ParameterBag;

class RequestInjectionsTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Middleware\RequestInjections::handle()
     */
    public function test()
    {

        $next = function ($request) {
            return $request;
        };

        $middleware = new RequestInjections();

        $route = m::mock(Route::class);
        $route->shouldReceive('parameter')->once()->with('key1')->andReturn('value1');
        $route->shouldReceive('parameter')->once()->with('key2')->andReturn('value2');

        $request = m::mock(Request::class);
        $request->request = new ParameterBag();
        $request->shouldReceive('route')->andReturn($route);

        $this->assertNull($request->request->get('key1'));
        $this->assertNull($request->request->get('key2'));
        $request = $middleware->handle($request, $next, 'key1', 'key2');
        $this->assertEquals('value1', $request->request->get('key1'));
        $this->assertEquals('value2', $request->request->get('key2'));
    }

}