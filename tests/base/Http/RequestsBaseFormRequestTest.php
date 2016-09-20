<?php

use Ohio\Core\Base\Http\Requests\BaseFormRequest;

class RequestsBaseFormRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Ohio\Core\Base\Http\Requests\BaseFormRequest::rules()
     * @covers \Ohio\Core\Base\Http\Requests\BaseFormRequest::wantsJson()
     * @covers \Ohio\Core\Base\Http\Requests\BaseFormRequest::authorize()
     */
    public function test()
    {
        $request = new BaseFormRequest();

        $this->assertEquals([], $request->rules());
        $this->assertTrue($request->wantsJson());
        $this->assertTrue($request->authorize());
    }

}