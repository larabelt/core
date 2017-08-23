<?php

use Mockery as m;

use Belt\Core\Team;
use Belt\Core\Http\ViewComposers\ActiveTeamComposer;
use Belt\Core\Services\ActiveTeamService;
use Belt\Core\Testing\BeltTestCase;
use Illuminate\Contracts\View\View;

class ActiveTeamComposerTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\ViewComposers\ActiveTeamComposer::compose
     */
    public function test()
    {
        // set active team
        Team::unguard();
        $team = factory(Team::class)->make(['id' => 1]);
        (new ActiveTeamService())->setTeam($team);

        # compose
        $view = m::mock(View::class);
        $view->shouldReceive('with')->once()->with('team', $team);
        $composer = new ActiveTeamComposer();
        $composer->compose($view);
    }
}