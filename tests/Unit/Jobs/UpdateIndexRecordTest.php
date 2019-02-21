<?php namespace Tests\Belt\Core\Unit\Jobs;

use Belt\Core\Facades\MorphFacade as Morph;
use Belt\Core\Jobs\UpdateIndexRecord;
use Belt\Core\Services\IndexService;
use Belt\Core\Tests;
use Mockery as m;

class UpdateIndexRecordTest extends Tests\BeltTestCase
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
     * @covers \Belt\Core\Jobs\UpdateIndexRecord::service
     * @covers \Belt\Core\Jobs\UpdateIndexRecord::handle
     */
    public function test()
    {
        $item = new UpdateIndexRecordStub(['id' => 123]);
        $job = new UpdateIndexRecord($item);

        # service
        $this->assertInstanceOf(IndexService::class, $job->service());

        # handle
        Morph::shouldReceive('morph')->with('test', 123)->andReturn($item);
        $service = m::mock(IndexService::class);
        $service->shouldReceive('setItem')->with($item)->andReturnSelf();
        $service->shouldReceive('upsert')->andReturnSelf();
        $job->service = $service;
        $job->handle();
    }

}

class UpdateIndexRecordStub extends Tests\BaseModelStub
{
    public function getMorphClass()
    {
        return 'test';
    }
}