<?php

use Ohio\Core\Role\Role;
use Ohio\Core\Role\Observers\RoleObserver;

class RoleObserverTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\Role\Observers\RoleObserver::creating
     */
    public function test()
    {

        $observer = new RoleObserver();

        # role name is empty
        $role = new Role();
        $observer->creating($role);
        $this->assertEmpty($role->slug);

        # role name is not empty
        $role = new Role();
        $role->name = 'TEST';
        $observer->creating($role);
        $this->assertEquals($role->slug, 'test');
    }

}