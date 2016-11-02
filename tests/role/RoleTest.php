<?php

use Ohio\Core\Base\Testing\OhioTestCase;
use Ohio\Core\Role\Role;

class RoleTest extends OhioTestCase
{
    /**
     * @covers \Ohio\Core\Role\Role::__toString
     * @covers \Ohio\Core\Role\Role::setNameAttribute
     * @covers \Ohio\Core\Role\Role::setSlugAttribute
     */
    public function test()
    {
        $role = factory(Role::class)->make();
        $role->name = ' test ';
        $role->slug = ' TEST_ ';

        $this->assertEquals($role->name, 'TEST');
        $this->assertEquals($role->name, $role->__toString());
        $this->assertEquals($role->slug, 'test');
    }

}