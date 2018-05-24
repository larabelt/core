<?php

use Belt\Core\Http\Requests\UpdateRole;

class UpdateRoleTest extends \PHPUnit\Framework\TestCase
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