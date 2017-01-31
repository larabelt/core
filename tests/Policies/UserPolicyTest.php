<?php

use Ohio\Core\Testing;
use Ohio\Core\Policies\UserPolicy;

class UserPolicyTest extends Testing\OhioTestCase
{

    use Testing\CommonMocks;

    /**
     * @covers \Ohio\Core\Policies\UserPolicy::view
     * @covers \Ohio\Core\Policies\UserPolicy::update
     */
    public function test()
    {
        $user1 = $this->getUser();
        $user2 = $this->getUser();

        $policy = new UserPolicy();

        # view
        $this->assertTrue($policy->view($user1, $user1));
        $this->assertFalse($policy->view($user1, $user2));

        # update
        $this->assertTrue($policy->update($user1, $user1));
        $this->assertFalse($policy->update($user1, $user2));
    }

}