<?php namespace Tests\Belt\Core\Unit\Policies;

use Belt\Core\Behaviors\Teamable;
use Belt\Core\Behaviors\TeamableInterface;
use Belt\Core\Policies\BaseAdminPolicy;
use Belt\Core\Services\ActiveTeamService;
use Tests\Belt\Core;
use Mockery as m;

class BaseAdminPolicyTest extends \Tests\Belt\Core\BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    use \Tests\Belt\Core\Base\CommonMocks;

    /**
     * @covers \Belt\Core\Policies\BaseAdminPolicy::teamService
     * @covers \Belt\Core\Policies\BaseAdminPolicy::view
     * @covers \Belt\Core\Policies\BaseAdminPolicy::create
     * @covers \Belt\Core\Policies\BaseAdminPolicy::update
     * @covers \Belt\Core\Policies\BaseAdminPolicy::delete
     * @covers \Belt\Core\Policies\BaseAdminPolicy::ofTeam
     */
    public function test()
    {

        $super = $this->getUser('super');
        $admin = $this->getUser('admin');
        $user = $this->getUser();
        $teamUser = $this->getUser('team');
        $team = $teamUser->teams->first();

        $policy = new BaseAdminPolicy();
        $policy->teamService()->setTeam($team);

        $stub = new BaseAdminPolicyStub();
        $teamableStub = new BaseAdminPolicyTeamableStub();
        $teamableStub->team = $team;

        # teamService
        $this->assertInstanceOf(ActiveTeamService::class, $policy->teamService());

        # view
        $this->assertNotTrue($policy->view($user, $stub));
        $this->assertNotTrue($policy->view($user, $stub));
        $this->assertTrue($policy->view($teamUser, $teamableStub));

        # update
        $this->assertNotTrue($policy->update($user, $stub));
        $this->assertNotTrue($policy->update($user, $teamableStub));
        $this->assertNotTrue($policy->update($teamUser, $stub));
        $this->assertTrue($policy->update($teamUser, $teamableStub));

        # delete
        $this->assertNotTrue($policy->delete($user, $stub));
        $this->assertNotTrue($policy->delete($user, $teamableStub));
        $this->assertNotTrue($policy->delete($teamUser, $stub));
        $this->assertTrue($policy->delete($teamUser, $teamableStub));

        # create
        $this->assertNotTrue($policy->create($user, 1));
        //$this->assertTrue($policy->create($teamUser, 1));
        $policy->teamService()->forgetTeam();
        //$this->assertNotTrue($policy->create($user, 1));

    }

}

class BaseAdminPolicyStub extends \Tests\Belt\Core\Base\BaseModelStub
{

}

class BaseAdminPolicyTeamableStub extends \Tests\Belt\Core\Base\BaseModelStub implements
    TeamableInterface
{
    use Teamable;

}