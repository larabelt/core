<?php

use Mockery as m;
use Ohio\Core\Testing;
use Ohio\Core\Role;
use Ohio\Core\Policies\BaseAdminPolicy;

class BaseAdminPolicyTest extends Testing\OhioTestCase
{

    use Testing\CommonMocks;

    /**
     * @covers \Ohio\Core\Policies\BaseAdminPolicy::before
     * @covers \Ohio\Core\Policies\BaseAdminPolicy::index
     * @covers \Ohio\Core\Policies\BaseAdminPolicy::view
     * @covers \Ohio\Core\Policies\BaseAdminPolicy::create
     * @covers \Ohio\Core\Policies\BaseAdminPolicy::update
     * @covers \Ohio\Core\Policies\BaseAdminPolicy::delete
     */
    public function test()
    {

        $super = $this->getUser('super');
        $admin = $this->getUser('admin');
        $user = $this->getUser();

        $policy = new BaseAdminPolicy();

        # before
        $this->assertTrue($policy->before($super, 1));
        $this->assertTrue($policy->before($admin, 1));
        $this->assertNull($policy->before($user, 1));

        # index
        $this->assertNull($policy->index($user));

        # view
        $this->assertNull($policy->view($user, 1));

        # create
        $this->assertNull($policy->create($user, 1));

        # update
        $this->assertNull($policy->update($user, 1));

        # delete
        $this->assertNull($policy->delete($user, 1));

    }

}