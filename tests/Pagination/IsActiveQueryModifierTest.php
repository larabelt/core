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
     */
    public function test()
    {
        # modify
        $qb = m::mock(Builder::class);
        $qb->shouldReceive('where')->once()->withArgs(['test.is_active', true]);
        $request = new IsActiveQueryModifierTestPaginateRequestStub(['is_active' => true]);
        $modifer = new IsActiveQueryModifier($qb, $request);
        $modifer->modify($qb, $request);

//        # elastic
//        $query = [];
//        $request = new IsActiveQueryModifierTestPaginateRequestStub(['is_active' => true]);
//        $query = IsActiveQueryModifier::elastic($query, $request);
//        $this->assertEquals(true, array_get($query, 'bool.must.0.terms.is_active.0'));

    }

}

class IsActiveQueryModifierTestPaginateRequestStub extends PaginateRequest {
    /**
     * @return string
     */
    public function morphClass()
    {
        return 'test';
    }
}