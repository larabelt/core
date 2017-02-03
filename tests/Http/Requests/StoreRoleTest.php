<?php

use Ohio\Core\Http\Requests\StoreRole;

class StoreRoleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\Http\Requests\StoreRole::rules
     */
    public function test()
    {

        $request = new StoreRole();

        $this->assertNotEmpty($request->rules());
    }

}