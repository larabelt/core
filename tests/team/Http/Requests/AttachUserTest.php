<?php

use Ohio\Core\Team\Http\Requests\AttachUser;

class AttachUserTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\Team\Http\Requests\AttachUser::rules
     */
    public function test()
    {

        $request = new AttachUser();

        $this->assertNotEmpty($request->rules());
    }

}