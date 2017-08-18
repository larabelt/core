<?php

use Belt\Core\Testing;
use Belt\Core\Policies\RolePolicy;

class RolePolicyTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

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