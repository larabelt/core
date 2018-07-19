<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Http\Requests\PaginateRequest;
use Belt\Content\Pagination\SubtypeQueryModifier;
use Illuminate\Database\Eloquent\Builder;

class SubtypeQueryModifierTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Content\Pagination\SubtypeQueryModifier::modify
     */
    public function test()
    {
        # modify
        $qb = m::mock(Builder::class);
        $qb->shouldReceive('where')->once()->withArgs(['test.subtype', true]);
        $request = new SubtypeQueryModifierTestPaginateRequestStub(['subtype' => true]);
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