<?php

use Mockery as m;
use Belt\Core\Jobs\DeleteIndexRecord;
use Belt\Core\Testing;
use Belt\Core\Services\IndexService;

class DeleteIndexRecordTest extends Testing\BeltTestCase
{

    public function setUp()
    {
        parent::setUp();
        DeleteIndexRecordStub::unguard();
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Jobs\DeleteIndexRecord::__construct
     * @covers \Belt\Core\Jobs\DeleteIndexRecord::handle
     */
    public function test()
    {
        $item = new DeleteIndexRecordStub(['id' => 123]);

        $service = m::mock(IndexService::class);
        $service->shouldReceive('delete')->with(123, 'test');

        $job = new DeleteIndexRecord($item);
        $job->service = $service;
        $job->handle();
    }

}

class DeleteIndexRecordStub extends Testing\BaseModelStub
{
    public function getMorphClass()
    {
        return 'test';
    }
}