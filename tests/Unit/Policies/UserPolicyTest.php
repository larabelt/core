<?php namespace Tests\Belt\Core\Unit\Policies;

use Belt\Core\Policies\UserPolicy;
use Belt\Core\Tests;

class UserPolicyTest extends Tests\BeltTestCase
{

    use Tests\CommonMocks;

    /**
     * @covers \Belt\Core\Policies\UserPolicy::view
     * @covers \Belt\Core\Policies\UserPolicy::update
     * @covers \Belt\Core\Policies\UserPolicy::register
     */
    public function test()
    {
        $user1 = $this->getUser();
        $user2 = $this->getUser();

        $policy = new UserPolicy();

        # view
        $this->assertTrue($policy->view($user1, $user1));
        $this->assertNotTrue($policy->view($user1, $user2));
        $this->assertNotTrue($policy->view($user1, new \stdClass()));

        # update
        $this->assertTrue($policy->update($user1, $user1));
        $this->assertNotTrue($policy->update($user1, $user2));
        $this->assertNotTrue($policy->update($user1, new \stdClass()));

        # register
        app()['config']->set('belt.core.users.allow_public_signup', false);
        $this->assertNotTrue($policy->register($user1));
        app()['config']->set('belt.core.users.allow_public_signup', true);
        $this->assertTrue($policy->register($user1));
    }

}