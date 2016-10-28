<?php

use Mockery as m;
use Ohio\Core\Base\Http\Requests\BasePaginateRequest;

class BasePaginateRequestTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Core\Base\Http\Requests\BasePaginateRequest::needle()
     * @covers \Ohio\Core\Base\Http\Requests\BasePaginateRequest::offset()
     * @covers \Ohio\Core\Base\Http\Requests\BasePaginateRequest::page()
     * @covers \Ohio\Core\Base\Http\Requests\BasePaginateRequest::perPage()
     * @covers \Ohio\Core\Base\Http\Requests\BasePaginateRequest::orderBy()
     * @covers \Ohio\Core\Base\Http\Requests\BasePaginateRequest::sortBy()
     * @covers \Ohio\Core\Base\Http\Requests\BasePaginateRequest::modifyQuery()
     */
    public function test()
    {
        $request = new BasePaginateRequest();

        $this->assertEmpty($request->needle());
        $this->assertEquals(1, $request->page());
        $this->assertEquals(0, $request->offset());
        $this->assertEquals($request->perPage, $request->perPage());
        $this->assertEquals($request->orderBy, $request->orderBy());
        $this->assertEquals($request->sortBy, $request->sortBy());

        $request = new BasePaginateRequest([
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
        $this->assertEquals($qbMock, $request->modifyQuery($qbMock));
    }

}