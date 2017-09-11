<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Http\Requests\PaginateRequest;
use Belt\Core\Pagination\IsActiveQueryModifier;
use Illuminate\Database\Eloquent\Builder;

class IsActiveQueryModifierTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Pagination\IsActiveQueryModifier::modify
     * @covers \Belt\Core\Pagination\IsActiveQueryModifier::elastic
     */
    public function test()
    {
        # modify
        $qb = m::mock(Builder::class);
        $qb->shouldReceive('where')->once()->withArgs(['is_active', true]);
        $request = new PaginateRequest(['is_active' => true]);
        $modifer = new IsActiveQueryModifier($qb, $request);
        $modifer->modify($qb, $request);

        # elastic
        $query = [];
        $request = new PaginateRequest(['is_active' => true]);
        $query = IsActiveQueryModifier::elastic($query, $request);
        $this->assertEquals(true, array_get($query, 'bool.must.0.terms.is_active.0'));

    }

}