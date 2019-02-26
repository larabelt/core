<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Requests\FormRequest;
use Tests\Belt\Core;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Routing\Route;
use Illuminate\Validation\Rules;
use Mockery as m;

class FormRequestTest extends \Tests\Belt\Core\BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Requests\FormRequest::rules
     * @covers \Belt\Core\Http\Requests\FormRequest::wantsJson
     * @covers \Belt\Core\Http\Requests\FormRequest::authorize
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

    }

    /**
     * @covers \Belt\Core\Http\Requests\FormRequest::ruleUnique
     */
    public function testRuleUnique()
    {
        $request = new FormRequestTestStub(['foo' => 1, 'bar' => 2]);

        $rule = $request->ruleUnique('tests', ['foo', 'bar']);

        $this->assertEquals('unique:tests,NULL,NULL,id,foo,1,bar,2', $rule->__toString());
    }

    /**
     * @covers \Belt\Core\Http\Requests\FormRequest::ruleExists
     */
    public function testRuleExists()
    {
        $request = m::mock(FormRequestTestStub::class . '[route]');
        $request->shouldReceive('route')->once()->with('foo')->andReturn(1);
        $request->shouldReceive('route')->once()->with('bar')->andReturn(2);

        $rule = $request->ruleExists('tests', 'test_id', ['foo', 'bar']);
        $this->assertEquals('exists:tests,test_id,foo,1,bar,2', $rule->__toString());
    }

    /**
     * @covers \Belt\Core\Http\Requests\FormRequest::failedValidation
     */
    public function testFailedValidation1()
    {
        $validator = m::mock(Validator::class);
        $validator->shouldReceive('passes')->once()->andReturn(false);
        $validator->shouldReceive('errors')->once()->andReturn([]);

        $methods = [
            'wantsJson',
            'prepareForValidation',
            'getValidatorInstance',
            'passesAuthorization',
        ];

        $request = m::mock(FormRequestTestStub::class . '[' . implode(',', $methods) . ']')
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $request->shouldReceive('wantsJson')->once()->andReturn(true);
        $request->shouldReceive('prepareForValidation')->once()->andReturnSelf();
        $request->shouldReceive('getValidatorInstance')->once()->andReturn($validator);
        $request->shouldReceive('passesAuthorization')->once()->andReturn(true);

        try {
            $request->validateResolved();
            $this->exceptionNotThrown();
        } catch (\Exception $e) {

        }
    }

    /**
     * @covers \Belt\Core\Http\Requests\FormRequest::failedValidation
     */
    public function testFailedValidation2()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $validator = m::mock(Validator::class);
        $validator->shouldReceive('passes')->once()->andReturn(false);

        $methods = [
            'wantsJson',
            'prepareForValidation',
            'getValidatorInstance',
            'passesAuthorization',
            'getRedirectUrl',
        ];

        $request = m::mock(FormRequestTestStub::class . '[' . implode(',', $methods) . ']')
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $request->shouldReceive('wantsJson')->once()->andReturn(false);
        $request->shouldReceive('prepareForValidation')->once()->andReturnSelf();
        $request->shouldReceive('getValidatorInstance')->once()->andReturn($validator);
        $request->shouldReceive('passesAuthorization')->once()->andReturn(true);
        $request->shouldReceive('getRedirectUrl')->once()->andReturn('');

        $request->validateResolved();
    }


}

class FormRequestTestStub extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:teams,name',
        ];
    }
}