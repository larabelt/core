<?php

use Ohio\Core\Team\Http\Requests\CreateRequest;

class CreateRequestTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\Team\Http\Requests\CreateRequest::rules
     */
    public function test()
    {

        $request = new CreateRequest();

        $this->assertNotEmpty($request->rules());
    }

}