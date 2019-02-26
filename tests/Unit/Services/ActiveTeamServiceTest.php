<?php namespace Tests\Belt\Core\Unit\Services;

use Belt\Core\Services\ActiveTeamService;
use Belt\Core\Team;
use Tests\Belt\Core;
use Belt\Core\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Mockery as m;

class ActiveTeamServiceTest extends \Tests\Belt\Core\BeltTestCase
{
    use \Tests\Belt\Core\Base\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Services\ActiveTeamService::__construct
     * @covers \Belt\Core\Services\ActiveTeamService::team
     * @covers \Belt\Core\Services\ActiveTeamService::setTeam
     * @covers \Belt\Core\Services\ActiveTeamService::getActiveTeamId
     * @covers \Belt\Core\Services\ActiveTeamService::getDefaultTeamId
     * @covers \Belt\Core\Services\ActiveTeamService::isAuthorized
     * @covers \Belt\Core\Services\ActiveTeamService::teamQB
     * @covers \Belt\Core\Services\ActiveTeamService::forgetTeam
     */
    public function test()
    {

        $user = $this->getUser();
        $team1 = factory(Team::class)->make(['id' => 1]);
        $team2 = factory(Team::class)->make(['id' => 2]);
        $user->teams->push($team1);
        $user->teams->push($team2);

        # __construct
        $service = new ActiveTeamService(['user' => $user]);
        $service->forgetTeam();
        $this->assertInstanceOf(Request::class, $service->request);
        $this->assertInstanceOf(User::class, $service->user);

        # teamQB
        $this->assertInstanceOf(Builder::class, $service->teamQB());

        # team
        $this->assertNull($service->team());

        # setTeam
        $service->setTeam($team2);
        $this->assertEquals($team2, $service->team());

        # getDefaultTeamId
        $this->assertEquals(1, $service->getDefaultTeamId());

        # getActiveTeamId
        $this->assertEquals(2, $service->getActiveTeamId());

        # forgetTeam
        $service->forgetTeam();
        $this->assertNull($service->team());

        # isAuthorized
        $this->assertTrue($service->isAuthorized(1));
        $this->assertTrue($service->isAuthorized(2));
        $this->assertFalse($service->isAuthorized(3));

        /**
         * additional tests for team-less user
         */
        $user = $this->getUser();
        $service = new ActiveTeamService(['user' => $user]);
        $this->assertNull($service->getDefaultTeamId());
        $this->assertFalse($service->isAuthorized(3));
        $user->setSuper(true);
        $this->assertTrue($service->isAuthorized(3));

    }


}
