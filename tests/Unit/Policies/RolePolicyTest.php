<?php namespace Tests\Belt\Core\Unit\Policies;

use Belt\Core\Policies\RolePolicy;
use Belt\Core\Tests;

class RolePolicyTest extends Tests\BeltTestCase
{

    use Tests\CommonMocks;

    /**
     * @covers \Belt\Core\Policies\RolePolicy::attach
     * @covers \Belt\Core\Policies\RolePolicy::detach
     */
    public function test()
    {
        $user = $this->getUser();

        $policy = new RolePolicy();

        # attach
        $this->assertNotTrue($policy->attach($user));

        # detach
        $this->assertNotTrue($policy->detach($user, 1));
    }

}