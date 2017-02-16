<?php

use Belt\Core\Http\Requests\UpdateRole;

class UpdateRoleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Belt\Core\Http\Requests\UpdateRole::rules
     */
    public function test()
    {

        $request = new UpdateRole();

        $this->assertNotEmpty($request->rules());
    }

}