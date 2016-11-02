<?php

use Ohio\Core\User\Http\Requests\CreateRequest;

class CreateRequestTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\User\Http\Requests\CreateRequest::rules
     */
    public function test()
    {

        $request = new CreateRequest();

        $this->assertNotEmpty($request->rules());
    }

}