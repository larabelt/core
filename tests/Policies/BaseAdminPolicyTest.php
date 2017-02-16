<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Role;
use Belt\Core\Policies\BaseAdminPolicy;

class BaseAdminPolicyTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    /**
     * @covers \Belt\Core\Policies\BaseAdminPolicy::before
     * @covers \Belt\Core\Policies\BaseAdminPolicy::index
     * @covers \Belt\Core\Policies\BaseAdminPolicy::view
     * @covers \Belt\Core\Policies\BaseAdminPolicy::create
     * @covers \Belt\Core\Policies\BaseAdminPolicy::update
     * @covers \Belt\Core\Policies\BaseAdminPolicy::delete
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