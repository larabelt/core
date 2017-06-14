<?php

use Mockery as m;
use Belt\Core\Http\Requests\PaginateRequest;
use Belt\Core\Pagination\GroupLengthAwarePaginator;
use Belt\Core\Pagination\IsActiveQueryModifier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GroupLengthAwarePaginatorTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Pagination\GroupLengthAwarePaginator::build
     */
    public function test()
    {
        $model = new GroupLengthAwarePaginatorModelStub();

        $qb = $model->newQuery();

        $request = new PaginateRequest([
            'perPage' => 25,
            'page' => 2,
            'q' => 'test',
            'group' => 'key',
        ]);

        $paginator = new GroupLengthAwarePaginator($qb, $request);

        $array = $paginator->toArray();

        $this->assertTrue(isset($array['meta']));
    }

}

class GroupLengthAwarePaginatorModelStub extends Model
{
    public function newQuery()
    {

        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('select')->once()->with('key')->andReturnSelf();
        $qbMock->shouldReceive('distinct')->once()->with('key')->andReturnSelf();
        $qbMock->shouldReceive('orderBy')->once()->with('key')->andReturnSelf();
        $qbMock->shouldReceive('where')->once()->with('key', 'LIKE', '%test%')->andReturnSelf();
        $qbMock->shouldReceive('count')->once()->with('key')->andReturn(100);
        $qbMock->shouldReceive('take')->once()->with(25);
        $qbMock->shouldReceive('offset')->once()->with(25);
        $qbMock->shouldReceive('get')->once();

        return $qbMock;
    }

}