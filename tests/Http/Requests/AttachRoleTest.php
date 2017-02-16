<?php

use Belt\Core\Http\Requests\AttachRole;

class AttachRoleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Belt\Core\Http\Requests\AttachRole::rules
     */
    public function test()
    {

        $request = new AttachRole();

        $this->assertNotEmpty($request->rules());
    }

}