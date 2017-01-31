<?php

use Ohio\Core\Testing;
use Ohio\Core\Policies\RolePolicy;

class RolePolicyTest extends Testing\OhioTestCase
{

    use Testing\CommonMocks;

    /**
     * @covers \Ohio\Core\Policies\RolePolicy::attach
     * @covers \Ohio\Core\Policies\RolePolicy::detach
     */
    public function test()
    {
        $user = $this->getUser();

        $policy = new RolePolicy();

        # attach
        $this->assertNull($policy->attach($user));

        # detach
        $this->assertNull($policy->detach($user, 1));
    }

}