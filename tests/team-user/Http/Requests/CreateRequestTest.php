<?php

use Ohio\Core\TeamUser\Http\Requests\CreateRequest;

class CreateRequestTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\TeamUser\Http\Requests\CreateRequest::rules
     */
    public function test()
    {

        $request = new CreateRequest();

        $this->assertNotEmpty($request->rules());
    }

}