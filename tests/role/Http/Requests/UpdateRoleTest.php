<?php

use Ohio\Core\Role\Http\Requests\UpdateRole;

class UpdateRoleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\Role\Http\Requests\UpdateRole::rules
     */
    public function test()
    {

        $request = new UpdateRole();

        $this->assertNotEmpty($request->rules());
    }

}