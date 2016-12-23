<?php

use Ohio\Core\UserRole\Http\Requests\StoreUserRole;

class StoreUserRoleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\UserRole\Http\Requests\StoreUserRole::rules
     */
    public function test()
    {

        $request = new StoreUserRole();

        $this->assertNotEmpty($request->rules());
    }

}