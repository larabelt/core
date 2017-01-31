<?php

use Ohio\Core\Testing;
use Ohio\Core\Policies\TeamPolicy;
use Ohio\Core\Team;
use Illuminate\Database\Eloquent\Collection;

class TeamPolicyTest extends Testing\OhioTestCase
{

    use Testing\CommonMocks;

    /**
     * @covers \Ohio\Core\Policies\TeamPolicy::view
     * @covers \Ohio\Core\Policies\TeamPolicy::create
     * @covers \Ohio\Core\Policies\TeamPolicy::delete
     * @covers \Ohio\Core\Policies\TeamPolicy::update
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