<?php

use Mockery as m;

use Ohio\Core\Base\Testing\OhioTestCase;
use Ohio\Core\TeamUser\TeamUser;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamUserTest extends OhioTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * covers \Ohio\Core\TeamUser\TeamUser::user
     * covers \Ohio\Core\TeamUser\TeamUser::team
     * covers \Ohio\Core\TeamUser\TeamUser::create
     */
    public function test()
    {

        $teamUser = new TeamUser();

        # user relationship
        $this->assertInstanceOf(BelongsTo::class, $teamUser->user());

        # team relationship
        $this->assertInstanceOf(BelongsTo::class, $teamUser->team());

        # create
        $teamUser = m::mock(TeamUser::class . '[firstOrCreate]');
        $teamUser->shouldReceive('firstOrCreate')->once();
        $teamUser->create();
    }

}