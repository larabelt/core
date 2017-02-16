<?php

use Belt\Core\Testing;
use Belt\Core\Policies\TeamPolicy;
use Belt\Core\Team;
use Illuminate\Database\Eloquent\Collection;

class TeamPolicyTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    /**
     * @covers \Belt\Core\Policies\TeamPolicy::view
     * @covers \Belt\Core\Policies\TeamPolicy::create
     * @covers \Belt\Core\Policies\TeamPolicy::delete
     * @covers \Belt\Core\Policies\TeamPolicy::update
     */
    public function test()
    {

        $user1 = $this->getUser();
        $team1 = factory(Team::class)->make();
        $team1->users = new Collection([$user1]);

        $user2 = $this->getUser();
        $team2 = factory(Team::class)->make();
        $team2->users = new Collection([$user2]);

        $policy = new TeamPolicy();

        # view
        $this->assertTrue($policy->view($user1, $team1));
        $this->assertFalse($policy->view($user1, $team2));

        # update
        $this->assertTrue($policy->update($user1, $team1));
        $this->assertFalse($policy->update($user1, $team2));

        # delete
        $this->assertTrue($policy->delete($user1, $team1));
        $this->assertFalse($policy->delete($user1, $team2));

        # create
        $this->assertTrue($policy->create($user1));
    }

}