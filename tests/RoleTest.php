<?php

use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Role;

class RoleTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Role::__toString
     * @covers \Belt\Core\Role::setNameAttribute
     */
    public function test()
    {
        $role = factory(Role::class)->make();
        $role->name = ' test ';
        $role->slug = ' TEST_ ';

        $this->assertEquals($role->name, 'TEST');
        $this->assertEquals($role->name, $role->__toString());
    }

}