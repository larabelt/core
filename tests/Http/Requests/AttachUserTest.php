<?php

use Belt\Core\Http\Requests\AttachUser;

class AttachUserTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Belt\Core\Http\Requests\AttachUser::rules
     */
    public function test()
    {

        $request = new AttachUser();

        $this->assertNotEmpty($request->rules());
    }

}