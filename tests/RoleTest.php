<?php

use Ohio\Core\Testing\OhioTestCase;
use Ohio\Core\Role;

class RoleTest extends OhioTestCase
{
    /**
     * @covers \Ohio\Core\Role::__toString
     * @covers \Ohio\Core\Role::setNameAttribute
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