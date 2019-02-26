<?php

namespace Tests\Belt\Core\Base;

use Mockery as m;
use Belt\Core\Http\Requests\PaginateRequest;
use Belt\Core\Pagination\DefaultLengthAwarePaginator;
use Belt\Core\User;
use Belt\Core\Team;
use Belt\Core\Services\ActiveTeamService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use GuzzleHttp;

/**
 * Class CommonMocks
 * @package Tests\Belt\Core
 */
trait CommonMocks
{

    /**
     * @return m\MockInterface
     */
    function getQBMock()
    {
        return $qbMock = m::mock(Builder::class);
    }

    /**
     * @param PaginateRequest|null $request
     * @param array $results
     * @return m\MockInterface
     */
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
        $qbMock->shouldReceive('get')->once()->andReturn($results);

        return $qbMock;
    }

    /**
     * @return m\MockInterface
     */
    function getPaginatorMock()
    {
        $paginatorMock = m::mock(DefaultLengthAwarePaginator::class);

        return $paginatorMock;
    }

    /**
     * @return m\MockInterface
     */
    function getGuzzleMock()
    {
        $response = new GuzzleHttp\Psr7\Response();

        $guzzle = m::mock(GuzzleHttp\Client::class . '[get]');
        $guzzle->shouldReceive('get')->andReturn($response);

        return $guzzle;
    }

    /**
     * @param null $type
     * @return mixed
     */
    function getUser($type = null)
    {
        $user = factory(User::class)->make(['super' => false]);
        $user->id = random_int(1, 10000);
        $user->roles = new Collection();

        if ($type == 'super') {
            $user->setSuper(true);
        }

        if ($type == 'admin') {
            $user->assign('admin');
        }

        if ($type == 'team') {
            Team::unguard();
            $team = factory(Team::class)->make([
                'id' => random_int(1, 999),
                'is_active' => true,
            ]);
            (new ActiveTeamService())->setTeam($team);
            $user->teams->push($team);
        }

        return $user;
    }

    /**
     * @param $path
     * @param string $name
     * @param string $mimetype
     * @return UploadedFile
     */
    function getUploadFile($path, $name = 'test.jpg', $mimetype = 'image/jpeg')
    {
        $file = new UploadedFile($path, $name, $mimetype, filesize($path), null, true);

        return $file;
    }

}
