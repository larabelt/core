<?php

use Mockery as m;
use Belt\Core\Http\Requests\FormRequest;
use Belt\Core\Testing;
use Illuminate\Routing\Route;
use Illuminate\Validation\Rules;

class FormRequestTest extends Testing\BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Requests\FormRequest::rules
     * @covers \Belt\Core\Http\Requests\FormRequest::wantsJson
     * @covers \Belt\Core\Http\Requests\FormRequest::authorize
     * @covers \Belt\Core\Http\Requests\FormRequest::ruleExists
     */
    public function test()
    {
        $request = new FormRequest();

        $this->assertEquals([], $request->rules());
        $this->assertFalse($request->wantsJson());
        $this->assertTrue($request->authorize());
        $this->assertInstanceOf(Rules\Exists::class, $request->ruleExists('table', 'column', ['foo' => 'bar']));

        # wantsJson
        $route = m::mock(Route::class);
        $route->shouldReceive('middleware')->andReturn(['api']);
        $request = m::mock(FormRequest::class . '[route,middle]');
        $request->shouldReceive('route')->andReturn($route);
        $this->assertTrue($request->wantsJson());

        # ruleExists

        # failedValidation
    }

}