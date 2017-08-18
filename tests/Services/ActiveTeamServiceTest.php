<?php

use Mockery as m;

use Belt\Core\Services\ActiveTeamService;
use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Team;
use Belt\Core\User;
use Illuminate\Http\Request;

class ActiveTeamServiceTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Services\ActiveTeamService::__construct
     * @covers \Belt\Core\Services\ActiveTeamService::team
     * @covers \Belt\Core\Services\ActiveTeamService::setTeam
     * @covers \Belt\Core\Services\ActiveTeamService::forgetTeam
     */
    public function test()
    {
        Team::unguard();
        $team = factory(Team::class)->make(['id' => 1]);

        # __construct
        $service = new ActiveTeamService();
        $this->assertInstanceOf(Request::class, $service->request);
        $this->assertInstanceOf(User::class, $service->user);

        # team
        $this->assertNull($service->team());

        # setTeam
        $service->setTeam($team);
        $this->assertEquals($team, $service->team());

        # forgetTeam
        $service->forgetTeam();
        $this->assertNull($service->team());

    }


}
