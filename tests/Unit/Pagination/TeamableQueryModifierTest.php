<?php namespace Tests\Belt\Core\Unit\Pagination;

use Belt\Core\Http\Requests\PaginateRequest;
use Belt\Core\Pagination\TeamableQueryModifier;
use Belt\Core\Tests;
use Illuminate\Database\Eloquent\Builder;
use Mockery as m;

class TeamableQueryModifierTest extends Tests\BeltTestCase
{

    use Tests\CommonMocks;

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