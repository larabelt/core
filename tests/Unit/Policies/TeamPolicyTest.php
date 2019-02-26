<?php namespace Tests\Belt\Core\Unit\Policies;

use Belt\Core\Policies\TeamPolicy;
use Belt\Core\Team;
use Tests\Belt\Core;
use Illuminate\Database\Eloquent\Collection;

class TeamPolicyTest extends \Tests\Belt\Core\BeltTestCase
{

    use \Tests\Belt\Core\Base\CommonMocks;

    /**
     * @covers \Belt\Core\Policies\TeamPolicy::view
     * @covers \Belt\Core\Policies\TeamPolicy::register
     * @covers \Belt\Core\Policies\TeamPolicy::delete
     * @covers \Belt\Core\Policies\TeamPolicy::update
     */
    public function test()
    {

        Team::unguard();

        $team1 = factory(Team::class)->make(['id' => 1]);
        $team1->id = 1;
        $user1 = $this->getUser();
        $user1->teams = new Collection([$team1]);

        $team2 = factory(Team::class)->make(['id' => 2]);
        $team2->id = 2;
        $user2 = $this->getUser();
        $user2->teams = new Collection([$team2]);

        $policy = new TeamPolicy();

        # view
        $this->assertTrue($policy->view($user1, $team1));
        $this->assertNotTrue($policy->view($user1, $team2));

        # update
        $this->assertTrue($policy->update($user1, $team1));
        $this->assertNotTrue($policy->update($user1, $team2));

        # delete
        $this->assertNotTrue($policy->delete($user1, $team1));

        # register
        app()['config']->set('belt.core.teams.allow_public_signup', false);
        $this->assertNotTrue($policy->register($user1));
        app()['config']->set('belt.core.teams.allow_public_signup', true);
        $this->assertTrue($policy->register($user1));
    }

}