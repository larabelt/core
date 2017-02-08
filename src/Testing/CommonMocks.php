<?php
namespace Ohio\Core\Testing;

use Mockery as m;
use Ohio\Core\Http\Requests\PaginateRequest;
use Ohio\Core\Pagination\BaseLengthAwarePaginator;
use Ohio\Core\User;
use Ohio\Core\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use GuzzleHttp;

trait CommonMocks
{

    function getQBMock()
    {
        return $qbMock = m::mock(Builder::class);
    }

    function getPaginateQBMock(PaginateRequest $request = null, $results = [])
    {

        $request = $request ?: new PaginateRequest();
        $results = new Collection($results);

        $qbMock = m::mock(Builder::class);

        if ($request->needle()) {
            $qbMock->shouldReceive('where')->once()->with(
                m::on(function (\Closure $closure) use ($request) {

                    $needle = $request->needle();

                    $subQBMock = m::mock('Illuminate\Database\Eloquent\Builder');

                    foreach ($request->searchable as $column) {
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

    function getPaginatorMock()
    {
        $paginatorMock = m::mock(BaseLengthAwarePaginator::class);

        return $paginatorMock;
    }

    function getGuzzleMock()
    {
        $response = new GuzzleHttp\Psr7\Response();

        $guzzle = m::mock(GuzzleHttp\Client::class . '[get]');
        $guzzle->shouldReceive('get')->andReturn($response);

        return $guzzle;
    }

    function getUser($type = null)
    {
        $user = factory(User::class)->make();
        $user->id = random_int(1, 10000);
        $user->roles = new Collection();

        if ($type == 'super') {
            $user->is_super = true;
        }

        if ($type == 'admin') {
            $user->roles->push(factory(Role::class)->make(['name' => 'ADMIN']));
        }

        return $user;
    }

    function getUploadFile($path, $name = 'test.jpg', $mimetype = 'image/jpeg')
    {
        $file = new UploadedFile($path, $name, filesize($path), $mimetype, null, true);

        return $file;
    }

}
