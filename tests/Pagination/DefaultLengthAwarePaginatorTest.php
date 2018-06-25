<?php

use Mockery as m;
use Belt\Core\Http\Requests\PaginateRequest;
use Belt\Core\Pagination\DefaultLengthAwarePaginator;
use Belt\Core\Pagination\IsActiveQueryModifier;
use Belt\Core\Team;
use Belt\Core\Testing;
use Illuminate\Database\Eloquent\Model;

class DefaultLengthAwarePaginatorTest extends Testing\BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Pagination\BaseLengthAwarePaginator::__construct
     * @covers \Belt\Core\Pagination\DefaultLengthAwarePaginator::build
     * @covers \Belt\Core\Pagination\BaseLengthAwarePaginator::setPaginator
     * @covers \Belt\Core\Pagination\BaseLengthAwarePaginator::toArray
     * @covers \Belt\Core\Pagination\BaseLengthAwarePaginator::orderBy
     */
    public function test()
    {
        $model = new DefaultLengthAwarePaginatorModelStub();

        $qb = $model->newQuery();

        $request = new PaginateRequest([
            'q' => 'test',
            'perPage' => 25,
            'page' => 2,
            'orderBy' => 'test.name',
            'sortBy' => 'desc',
        ]);
        $request->searchable[] = 'test.id';
        $request->searchable[] = 'test.name';
        $request->sortable[] = 'test.name';
        $request->queryModifiers[] = IsActiveQueryModifier::class;

        $paginator = new DefaultLengthAwarePaginator($qb, $request);
        $paginator->build();

        $array = $paginator->toArray();

        $this->assertTrue(isset($array['meta']));
    }

    /**
     * @covers \Belt\Core\Pagination\BaseLengthAwarePaginator::groupBy
     */
    public function testGroupBy()
    {
        $model = new DefaultLengthAwarePaginatorModelGroupByStub();

        $qb = $model->newQuery();

        $request = new PaginateRequest([
            'perPage' => 0,
            'groupBy' => 'test.groupable_type',
        ]);
        $request->groupable = 'test.groupable_type';

        $paginator = new DefaultLengthAwarePaginator($qb, $request);
        $paginator->build();
    }

    /**
     * @covers \Belt\Core\Pagination\DefaultLengthAwarePaginator::build
     */
    public function testCount()
    {

        $qb = (new DefaultLengthAwarePaginatorEmptyCount())->newQuery();
        $request = new PaginateRequest(['perPage' => 3]);
        $paginator = new DefaultLengthAwarePaginator($qb, $request);

        $paginator->build();

        $this->assertEquals(4, array_get($paginator->toArray(), 'total'));
    }

    /**
     * @covers \Belt\Core\Pagination\DefaultLengthAwarePaginator::build
     */
    public function testJoins()
    {
        $request = m::mock(PaginateRequest::class . '[fullKey]');
        $request->shouldReceive('fullKey')->andReturn('');
        $request->joins[] = function ($qb, $request) {
        };

        $qb = (new DefaultLengthAwarePaginatorJoins())->newQuery();
        $paginator = new DefaultLengthAwarePaginator($qb, $request);

        $paginator->build();
    }

}

class DefaultLengthAwarePaginatorModelStub extends Model
{
    public function newQuery()
    {

        $qbMock = m::mock('Illuminate\Database\Eloquent\Builder');
        $qbMock->shouldReceive('where')->once()->with(
            m::on(function (\Closure $closure) {

                $subQBMock = m::mock('Illuminate\Database\Eloquent\Builder');
                $subQBMock->shouldReceive('orWhere')->once()->with('test.id', 'LIKE', '%test%');
                $subQBMock->shouldReceive('orWhere')->once()->with('test.name', 'LIKE', '%test%');

                $closure($subQBMock);

                // return a bool here so Mockery knows expectation passed
                return is_callable($closure);
            })
        );

        $qbMock->shouldReceive('orderBy')->once()->with('test.name', 'desc');
        $qbMock->shouldReceive('count')->once()->andReturn(1000);
        $qbMock->shouldReceive('take')->once()->with(25);
        $qbMock->shouldReceive('offset')->once()->with(25);
        $qbMock->shouldReceive('get')->once();

        return $qbMock;
    }

}

class DefaultLengthAwarePaginatorModelGroupByStub extends Model
{
    public function newQuery()
    {
        $qbMock = m::mock('Illuminate\Database\Eloquent\Builder');
        $qbMock->shouldReceive('select')->once()->with(['test.groupable_type']);
        $qbMock->shouldReceive('groupBy')->once()->with('test.groupable_type');
        $qbMock->shouldReceive('orderBy')->once()->with('test.groupable_type', 'asc');
        $qbMock->shouldReceive('count')->once()->andReturn(1000);
        $qbMock->shouldReceive('get')->once();

        return $qbMock;
    }

}

class DefaultLengthAwarePaginatorEmptyCount extends Model
{
    public function newQuery()
    {

        $qbMock = m::mock('Illuminate\Database\Eloquent\Builder');
        $qbMock->shouldReceive('select')->andReturnSelf();
        $qbMock->shouldReceive('groupBy')->andReturnSelf();
        $qbMock->shouldReceive('orderBy')->andReturnSelf();
        $qbMock->shouldReceive('take')->andReturnSelf();
        $qbMock->shouldReceive('count')->once()->andThrow(new Exception());
        $qbMock->shouldReceive('get')->andReturn(factory(Team::class, 3)->make());

        return $qbMock;
    }

}

class DefaultLengthAwarePaginatorJoins extends Model
{
    public function newQuery()
    {

        $qbMock = m::mock('Illuminate\Database\Eloquent\Builder');
        $qbMock->shouldReceive('select')->andReturnSelf();
        $qbMock->shouldReceive('groupBy')->andReturnSelf();
        $qbMock->shouldReceive('orderBy')->andReturnSelf();
        $qbMock->shouldReceive('take')->andReturnSelf();
        $qbMock->shouldReceive('count')->once()->andThrow(new Exception());
        $qbMock->shouldReceive('get')->andReturn(new \Illuminate\Database\Eloquent\Collection());

        return $qbMock;
    }

}