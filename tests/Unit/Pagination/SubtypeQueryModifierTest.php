<?php namespace Tests\Belt\Core\Unit\Pagination;

use Belt\Core\Http\Requests\PaginateRequest;
use Belt\Core\Pagination\SubtypeQueryModifier;
use Belt\Core\Tests;
use Illuminate\Database\Eloquent\Builder;
use Mockery as m;

class SubtypeQueryModifierTest extends Tests\BeltTestCase
{

    use Tests\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Pagination\SubtypeQueryModifier::modify
     */
    public function test()
    {
        # modify
        $qb = m::mock(Builder::class);
        $qb->shouldReceive('whereIn')->once()->withArgs(['test.subtype', ['foo', 'bar']]);
        $request = new SubtypeQueryModifierTestPaginateRequestStub(['subtype' => 'foo,bar']);
        $modifer = new SubtypeQueryModifier($qb, $request);
        $modifer->modify($qb, $request);

    }

}

class SubtypeQueryModifierTestPaginateRequestStub extends PaginateRequest {
    /**
     * @return string
     */
    public function morphClass()
    {
        return 'test';
    }
}