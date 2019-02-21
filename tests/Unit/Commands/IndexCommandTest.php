<?php namespace Tests\Belt\Core\Unit\Commands;

use Belt\Core\Commands\IndexCommand;
use Belt\Core\Services\IndexService;
use Mockery as m;

class IndexCommandTest extends \PHPUnit\Framework\TestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Commands\IndexCommand::service
     * @covers \Belt\Core\Commands\IndexCommand::handle
     */
    public function test()
    {

        // service
        $cmd = new IndexCommand();
        $this->assertInstanceOf(IndexService::class, $cmd->service());

        // handle (merge-schema)
        $service = m::mock(IndexService::class);
        $service->shouldReceive('mergeSchema')->with('events')->andReturnSelf();
        $cmd = m::mock(IndexCommand::class . '[argument,option,service]');
        $cmd->shouldReceive('service')->andReturn($service);
        $cmd->shouldReceive('argument')->with('action')->andReturn('merge-schema');
        $cmd->shouldReceive('option')->with('type')->andReturn('events');
        $cmd->handle();

        // handle (batch-upsert)
        $service = m::mock(IndexService::class);
        $service->shouldReceive('batchUpsert')->with('events')->andReturnSelf();
        $cmd = m::mock(IndexCommand::class . '[argument,option,service]');
        $cmd->shouldReceive('service')->andReturn($service);
        $cmd->shouldReceive('argument')->with('action')->andReturn('batch-upsert');
        $cmd->shouldReceive('option')->with('type')->andReturn('events');
        $cmd->handle();
    }

}
