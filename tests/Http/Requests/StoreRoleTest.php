<?php

use Belt\Core\Http\Requests\StoreRole;

class StoreRoleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Belt\Core\Http\Requests\StoreRole::rules
     */
    public function test()
    {

        $request = new StoreRole();

        $this->assertNotEmpty($request->rules());
    }

}