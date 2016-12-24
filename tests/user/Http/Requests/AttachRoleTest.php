<?php

use Ohio\Core\User\Http\Requests\AttachRole;

class AttachRoleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\User\Http\Requests\AttachRole::rules
     */
    public function test()
    {

        $request = new AttachRole();

        $this->assertNotEmpty($request->rules());
    }

}