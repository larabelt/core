<?php

use Mockery as m;
use Ohio\Core\Http\Requests\PaginateRequest;

class PaginateRequestTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Core\Http\Requests\PaginateRequest::needle()
     * @covers \Ohio\Core\Http\Requests\PaginateRequest::offset()
     * @covers \Ohio\Core\Http\Requests\PaginateRequest::page()
     * @covers \Ohio\Core\Http\Requests\PaginateRequest::perPage()
     * @covers \Ohio\Core\Http\Requests\PaginateRequest::orderBy()
     * @covers \Ohio\Core\Http\Requests\PaginateRequest::sortBy()
     * @covers \Ohio\Core\Http\Requests\PaginateRequest::modifyQuery()
     * @covers \Ohio\Core\Http\Requests\PaginateRequest::items()
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
    }

}