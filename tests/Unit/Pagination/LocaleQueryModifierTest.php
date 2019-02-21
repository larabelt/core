<?php namespace Tests\Belt\Core\Unit\Pagination;

use Belt\Core\Http\Requests\PaginateRequest;
use Belt\Core\Pagination\LocaleQueryModifier;
use Belt\Core\Tests;
use Illuminate\Database\Eloquent\Builder;
use Mockery as m;

class LocaleQueryModifierTest extends Tests\BeltTestCase
{

    use Tests\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Pagination\LocaleQueryModifier::modify
     */
    public function test()
    {
        # modify
        $qb = m::mock(Builder::class);
        $qb->shouldReceive('where')->once()->with('locale', 'foo');

        $request = new LocaleQueryModifierTestPaginateRequestStub(['locale' => 'foo']);

        $modifer = new LocaleQueryModifier($qb, $request);
        $modifer->modify($qb, $request);

    }

}

class LocaleQueryModifierTestPaginateRequestStub extends PaginateRequest
{
    /**
     * @return string
     */
    public function morphClass()
    {
        return 'test';
    }
}