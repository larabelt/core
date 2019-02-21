<?php namespace Tests\Belt\Core\Unit\Pagination;

use Belt\Core\Http\Requests\PaginateUsers;
use Belt\Core\Pagination\InQueryModifier;
use Belt\Core\Tests;
use Illuminate\Database\Eloquent\Builder;
use Mockery as m;

class InQueryModifierTest extends Tests\BeltTestCase
{

    use Tests\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Pagination\InQueryModifier::modify
     */
    public function test()
    {
        # modify (in)
        $qb = m::mock(Builder::class);
        $qb->shouldReceive('whereIn')->once()->with('users.id', [1,3]);
        $request = new PaginateUsers(['in' => '1,3']);
        $modifer = new InQueryModifier($qb, $request);
        $modifer->modify($qb, $request);

        # modify (not_in)
        $qb = m::mock(Builder::class);
        $qb->shouldReceive('whereNotIn')->once()->with('users.id', [2]);
        $request = new PaginateUsers(['not_in' => '2']);
        $modifer = new InQueryModifier($qb, $request);
        $modifer->modify($qb, $request);

    }

}