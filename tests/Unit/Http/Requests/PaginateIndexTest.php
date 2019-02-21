<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Requests\PaginateIndex;
use Belt\Core\Services\IndexService;
use Belt\Core\Tests;
use Illuminate\Database\Eloquent\Builder;
use Mockery as m;

class PaginateIndexTest extends Tests\BeltTestCase
{

    use Tests\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Requests\PaginateIndex::service
     * @covers \Belt\Core\Http\Requests\PaginateIndex::modifyQuery
     */
    public function test()
    {
        # service
        $paginateRequest = new PaginateIndex();
        $this->assertInstanceOf(IndexService::class, $paginateRequest->service());

        # modifyQuery
        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('whereIn')->once()->with('index.indexable_id', [1, 2]);
        $qbMock->shouldReceive('whereIn')->once()->with('index.indexable_type', ['places', 'events']);
        $qbMock->shouldReceive('where')->once()->with('index.name', 'foo');
        $paginateRequest = new PaginateIndex(['type' => 'places,events', 'id' => '1,2', 'name' => 'foo']);
        $paginateRequest->modifyQuery($qbMock);

        # modifyQuery (groupBy)
        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('select')->once()->with(['index.indexable_type']);
        $qbMock->shouldReceive('groupBy')->once()->with('index.indexable_type');
        $paginateRequest = new PaginateIndex(['groupBy' => 'indexable_type']);
        $paginateRequest->modifyQuery($qbMock);
        $this->assertEquals('index.indexable_type', $paginateRequest->orderBy());
    }

}