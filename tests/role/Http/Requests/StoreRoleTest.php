<?php

use Ohio\Core\Role\Http\Requests\StoreRole;

class StoreRoleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\Role\Http\Requests\StoreRole::rules
     */
    public function test()
    {

        $request = new StoreRole();

        $this->assertNotEmpty($request->rules());
    }

}