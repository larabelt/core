<?php namespace Tests\Belt\Core\Unit\Pagination;

use Belt\Core\Http\Requests\PaginateRequest;
use Belt\Core\Pagination\BaseLengthAwarePaginator;
use Tests\Belt\Core;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery as m;

class BaseLengthAwarePaginatorTest extends \Tests\Belt\Core\BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Pagination\BaseLengthAwarePaginator::__construct
     * @covers \Belt\Core\Pagination\BaseLengthAwarePaginator::setPaginator
     * @covers \Belt\Core\Pagination\BaseLengthAwarePaginator::toArray
     * @covers \Belt\Core\Pagination\BaseLengthAwarePaginator::orderBy
     * @covers \Belt\Core\Pagination\BaseLengthAwarePaginator::embed
     * @covers \Belt\Core\Pagination\BaseLengthAwarePaginator::groupBy
     */
    public function test()
    {
        # __construct, setPaginator, toArray
        $request = new PaginateRequest(['foo' => 'bar']);
        $paginator = new BaseLengthAwarePaginatorStub(m::mock(Builder::class), $request);
        $paginator->setPaginator(new LengthAwarePaginator([], 0, 10));
        $this->assertEquals(['foo' => 'bar'], array_get($paginator->toArray(), 'meta.request'));

        # orderBy
        $builder = m::mock(Builder::class);
        $builder->shouldReceive('orderBy')->once()->with('foo.id', 'asc')->andReturnSelf();
        $builder->shouldReceive('orderBy')->once()->with('foo.name', 'desc')->andReturnSelf();
        $request = new PaginateRequest(['orderBy' => 'foo.id,-foo.name']);
        $request->sortable = ['foo.id', 'foo.name'];
        $paginator = new BaseLengthAwarePaginatorStub($builder, $request);
        $paginator->orderBy($request);

        # orderBy (part 2)
        $request = new PaginateRequest();
        $request->orderBy = null;
        $paginator = new BaseLengthAwarePaginatorStub(m::mock(Builder::class), $request);
        $paginator->orderBy($request);

        # embed
        $builder = m::mock(Builder::class);
        $builder->shouldReceive('with')->once()->with('params')->andReturnSelf();
        $builder->shouldReceive('with')->once()->with('attachments')->andReturnSelf();
        $request = new PaginateRequest(['embed' => 'params,attachments']);
        $paginator = new BaseLengthAwarePaginatorStub($builder, $request);
        $paginator->embed($request);

        # groupBy
        $builder = m::mock(Builder::class);
        $builder->shouldReceive('select')->once()->with(['test.groupable_type']);
        $builder->shouldReceive('groupBy')->once()->with('test.groupable_type');
        $request = new PaginateRequest(['perPage' => 0, 'groupBy' => 'test.groupable_type']);
        $request->groupable = 'test.groupable_type';
        $paginator = new BaseLengthAwarePaginatorStub($builder, $request);
        $paginator->groupBy($request);
    }

}

class BaseLengthAwarePaginatorStub extends BaseLengthAwarePaginator
{
    public function build()
    {

    }
}