<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Http\Requests\PaginateRequest;
use Belt\Core\Pagination\TeamableQueryModifier;
use Illuminate\Database\Eloquent\Builder;

class TeamableQueryModifierTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Pagination\TeamableQueryModifier::modify
     */
    public function test()
    {
        # modify
        $qb = m::mock(Builder::class);
        $qb->shouldReceive('where')->once()->withArgs(['team_id', 1]);
        $request = new PaginateRequest(['team_id' => 1]);
        $modifer = new TeamableQueryModifier($qb, $request);
        $modifer->modify($qb, $request);

    }

}