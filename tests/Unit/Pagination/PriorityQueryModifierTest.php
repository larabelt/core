<?php namespace Tests\Belt\Core\Unit\Pagination;

use Belt\Core\Http\Requests\PaginateRequest;
use Belt\Core\Pagination\PriorityQueryModifier;
use Belt\Core\Tests;
use Illuminate\Database\Eloquent\Builder;
use Mockery as m;

class PriorityQueryModifierTest extends Tests\BeltTestCase
{

    use Tests\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Pagination\PriorityQueryModifier::modify
     */
    public function test()
    {
        # modify
        $qb = m::mock(Builder::class);
        $qb->shouldReceive('where')->once()->withArgs(['test.priority', '>=', 2]);
        $request = new PriorityQueryModifierStub(['priority' => 2]);
        $modifer = new PriorityQueryModifier($qb, $request);
        $modifer->modify($qb, $request);

    }

}

class PriorityQueryModifierStub extends PaginateRequest {
    /**
     * @return string
     */
    public function morphClass()
    {
        return 'test';
    }
}