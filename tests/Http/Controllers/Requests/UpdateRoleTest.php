<?php

use Ohio\Core\Http\Requests\UpdateRole;

class UpdateRoleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\Http\Requests\UpdateRole::rules
     */
    public function test()
    {

        $request = new UpdateRole();

        $this->assertNotEmpty($request->rules());
    }

}