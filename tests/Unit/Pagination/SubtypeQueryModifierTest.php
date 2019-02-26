<?php namespace Tests\Belt\Core\Unit\Pagination;

use Belt\Core\Http\Requests\PaginateRequest;
use Belt\Core\Pagination\SubtypeQueryModifier;
use Tests\Belt\Core;
use Illuminate\Database\Eloquent\Builder;
use Mockery as m;

class SubtypeQueryModifierTest extends \Tests\Belt\Core\BeltTestCase
{

    use \Tests\Belt\Core\Base\CommonMocks;

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