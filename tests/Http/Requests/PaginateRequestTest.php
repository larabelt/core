<?php

use Mockery as m;
use Belt\Core\Http\Requests\PaginateRequest;

class PaginateRequestTest extends \PHPUnit_Framework_TestCase
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

        #extend
        $request = new \Illuminate\Http\Request(['foo' => 'bar']);
        $request = PaginateRequest::extend($request);
        $this->assertEquals('bar', $request->get('foo'));
    }

}