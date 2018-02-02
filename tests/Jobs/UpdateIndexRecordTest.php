<?php

use Mockery as m;
use Belt\Core\Facades\MorphFacade as Morph;
use Belt\Core\Jobs\UpdateIndexRecord;
use Belt\Core\Testing;
use Belt\Core\Services\IndexService;

class UpdateIndexRecordTest extends Testing\BeltTestCase
{

    public function setUp()
    {
        parent::setUp();
        UpdateIndexRecordStub::unguard();
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Jobs\UpdateIndexRecord::__construct
     * @covers \Belt\Core\Jobs\UpdateIndexRecord::handle
     */
    public function test()
    {
        $item = new UpdateIndexRecordStub(['id' => 123]);

        Morph::shouldReceive('morph')->with('test', 123)->andReturn($item);

        $service = m::mock(IndexService::class);
        $service->shouldReceive('setItem')->with($item)->andReturnSelf();
        $service->shouldReceive('upsert')->andReturnSelf();

        $job = new UpdateIndexRecord($item);
        $job->service = $service;
        $job->handle();
    }

}

class UpdateIndexRecordStub extends Testing\BaseModelStub
{
    public function getMorphClass()
    {
        return 'test';
    }
}