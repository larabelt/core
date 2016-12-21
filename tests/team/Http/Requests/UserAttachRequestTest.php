<?php

use Ohio\Core\Team\Http\Requests\UserAttachRequest;

class UserAttachRequestTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\Team\Http\Requests\UserAttachRequest::rules
     */
    public function test()
    {

        $request = new UserAttachRequest();

        $this->assertNotEmpty($request->rules());
    }

}