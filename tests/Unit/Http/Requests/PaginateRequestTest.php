<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Requests\PaginateRequest;
use Tests\Belt\Core;
use Belt\Core\User;
use Illuminate\Database\Eloquent\Builder;
use Mockery as m;

class PaginateRequestTest extends \Tests\Belt\Core\BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Requests\PaginateRequest::needle
     * @covers \Belt\Core\Http\Requests\PaginateRequest::offset
     * @covers \Belt\Core\Http\Requests\PaginateRequest::page
     * @covers \Belt\Core\Http\Requests\PaginateRequest::perPage
     * @covers \Belt\Core\Http\Requests\PaginateRequest::orderBy
     * @covers \Belt\Core\Http\Requests\PaginateRequest::sortBy
     * @covers \Belt\Core\Http\Requests\PaginateRequest::modifyQuery
     * @covers \Belt\Core\Http\Requests\PaginateRequest::items
     * @covers \Belt\Core\Http\Requests\PaginateRequest::reCapture
     * @covers \Belt\Core\Http\Requests\PaginateRequest::extend
     * @covers \Belt\Core\Http\Requests\PaginateRequest::model
     * @covers \Belt\Core\Http\Requests\PaginateRequest::qb
     * @covers \Belt\Core\Http\Requests\PaginateRequest::fullKey
     * @covers \Belt\Core\Http\Requests\PaginateRequest::morphClass
     * @covers \Belt\Core\Http\Requests\PaginateRequest::refetch
     * @covers \Belt\Core\Http\Requests\PaginateRequest::item
     * @covers \Belt\Core\Http\Requests\PaginateRequest::groupBy
     * @covers \Belt\Core\Http\Requests\PaginateRequest::append
     * @covers \Belt\Core\Http\Requests\PaginateRequest::embed
     */
    public function test()
    {
        $request = new PaginateRequest();

        $this->assertEmpty($request->needle());
        $this->assertEquals(1, $request->page());
        $this->assertEquals(0, $request->offset());
        $this->assertEquals($request->perPage, $request->perPage());
        $this->assertEquals($request->orderBy, $request->orderBy());
        $this->assertEquals($request->sortBy, $request->sortBy());

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

        $this->assertEquals('test', $request->needle());
        $this->assertEquals(25, $request->offset());
        $this->assertEquals(2, $request->page());
        $this->assertEquals(25, $request->perPage());
        $this->assertEquals('test.name', $request->orderBy());
        $this->assertEquals('desc', $request->sortBy());

        $qbMock = m::mock('Illuminate\Database\Eloquent\Builder');
        $qbMock->shouldReceive('get')->andReturn([]);
        $this->assertEquals($qbMock, $request->modifyQuery($qbMock));
        $this->assertEquals([], $request->items($qbMock));

        # recapture
        $this->assertEmpty($request->server);
        $request->reCapture();
        $this->assertNotEmpty($request->server);

        # extend
        $request = new \Illuminate\Http\Request(['foo' => 'bar']);
        $request = PaginateRequest::extend($request);
        $this->assertEquals('bar', $request->get('foo'));

        # model
        $request->modelClass = User::class;
        $this->assertInstanceOf(User::class, $request->model());

        # qb
        $this->assertInstanceOf(Builder::class, $request->qb());

        # morphClass
        $this->assertEquals('users', $request->morphClass());

        # fullKey
        $this->assertEquals('users.id', $request->fullKey());

        # item
        User::unguard();
        $user = factory(User::class)->make(['id' => 1]);
        $qb = m::mock(Builder::class);
        $qb->shouldReceive('find')->andReturn($user);
        $userRepo = m::mock(User::class);
        $userRepo->shouldReceive('newQuery')->andReturn($qb);
        $userRepo->shouldReceive('getTable')->andReturn('users');
        $userRepo->shouldReceive('getKeyName')->andReturn('id');
        $request->model = $userRepo;
        $this->assertEquals($user, $request->item(1));

        # refetch
        $users = new \Illuminate\Database\Eloquent\Collection([$user]);
        $qb = m::mock(Builder::class);
        $qb->shouldReceive('get')->with(['users.id'])->andReturn($users);
        $request->refetch($qb);

        # perPage
        $request = new PaginateRequest(['perPage' => 0]);
        $this->assertEmpty($request->perPage());
        $request = new PaginateRequest();
        $request->perPage = 0;
        $this->assertEmpty($request->perPage());

        # orderBy
        $request = new PaginateRequest();
        $request->orderBy = 'test.id';
        $request->sortable[] = 'test.id';
        $request->sortable[] = 'test.name';
        $request->merge(['orderBy' => 'test.name']);
        $this->assertEquals('test.name', $request->orderBy());
        $request->merge(['orderBy' => '-test.name']);
        $this->assertEquals('-test.name', $request->orderBy());
        $request->merge(['orderBy' => '-test.name,test.id']);
        $this->assertEquals('-test.name,test.id', $request->orderBy());
        $request->merge(['orderBy' => '-test.name,test.not_allowed']);
        $this->assertEquals('test.id', $request->orderBy());

        # groupBy
        $request = new PaginateRequest(['groupBy' => 'test.testable_type']);
        $request->groupable[] = 'test.testable_type';
        $this->assertEquals('test.testable_type', $request->groupBy());
        $request = new PaginateRequest(['groupBy' => 'test.testable_type']);
        $request->groupable[] = null;
        $this->assertNull($request->groupBy());

        # append
        $this->assertEquals([], (new PaginateRequest())->append());
        $this->assertEquals(['foo', 'bar'], (new PaginateRequest(['append' => 'foo,bar']))->append());

        # embed
        $this->assertEquals([], (new PaginateRequest())->embed());
        $this->assertEquals(['foo', 'bar'], (new PaginateRequest(['embed' => 'foo,bar']))->embed());

        # items
        $user = m::mock(User::class);
        $user->shouldReceive('append')->with(['foo', 'bar'])->andReturnSelf();
        $builder = m::mock(Builder::class);
        $builder->shouldReceive('get')->andReturn([$user]);
        (new PaginateRequest(['append' => 'foo,bar']))->items($builder);

    }

}