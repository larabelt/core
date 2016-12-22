<?php

use Ohio\Core\Base\Http\Requests\FormRequest;

class FormRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Ohio\Core\Base\Http\Requests\FormRequest::rules()
     * @covers \Ohio\Core\Base\Http\Requests\FormRequest::wantsJson()
     * @covers \Ohio\Core\Base\Http\Requests\FormRequest::authorize()
     */
    public function test()
    {
        $request = new FormRequest();

        $this->assertEquals([], $request->rules());
        $this->assertTrue($request->wantsJson());
        $this->assertTrue($request->authorize());
    }

}