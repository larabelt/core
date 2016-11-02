<?php
namespace Ohio\Core\Base\Testing;

use Mockery as m;
use Ohio\Core\Base\Http\Requests\BasePaginateRequest;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

trait TestPaginateTrait
{

    function getPaginateQBMock(BasePaginateRequest $request = null, $results = [])
    {

        $request = $request ?: new BasePaginateRequest();
        $results = new Collection($results);

        $qbMock = m::mock(Builder::class);


        if ($request->needle()) {
            $qbMock->shouldReceive('where')->once()->with(
                m::on(function (\Closure $closure) use ($request) {

                    $needle = $request->needle();

                    $subQBMock = m::mock('Illuminate\Database\Eloquent\Builder');

                    foreach($request->searchable as $column) {
                        $subQBMock->shouldReceive('orWhere')->once()->with($column, 'LIKE', "%$needle%s");
                    }

                    $closure($subQBMock);

                    // return a bool here so Mockery knows expectation passed
                    return is_callable($closure);
                })
            );
        }

        $qbMock->shouldReceive('orderBy')->once()->with($request->orderBy(), $request->sortBy());
        $qbMock->shouldReceive('count')->once()->andReturn($request->perPage());
        $qbMock->shouldReceive('take')->once()->with($request->perPage());
        $qbMock->shouldReceive('offset')->once()->with($request->offset());
        $qbMock->shouldReceive('get')->once()->andReturn($results);

        return $qbMock;
    }

}
