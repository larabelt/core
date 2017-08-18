<?php

use Belt\Core\Testing;
use Belt\Core\Policies\UserPolicy;

class UserPolicyTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    /**
     * @covers \Belt\Core\Policies\UserPolicy::view
     * @covers \Belt\Core\Policies\UserPolicy::update
     */
    public function test()
    {
        $user1 = $this->getUser();
        $user2 = $this->getUser();

        $policy = new UserPolicy();

        # view
        $this->assertTrue($policy->view($user1, $user1));
        $this->assertNotTrue($policy->view($user1, $user2));

        # update
        $this->assertTrue($policy->update($user1, $user1));
        $this->assertNotTrue($policy->update($user1, $user2));
    }

}