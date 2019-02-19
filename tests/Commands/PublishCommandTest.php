<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Commands\PublishCommand;
use Belt\Core\Services\PublishService;

class PublishCommandTest extends Testing\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Commands\PublishCommand::handle
     */
    public function testHandle()
    {

        # service update
        $service = m::mock(PublishService::class);
        $service->shouldReceive('update')->andReturnNull();
        $cmd = m::mock(PublishCommand::class . '[argument, service]');
        $cmd->shouldReceive('argument')->andReturn('update');
        $cmd->shouldReceive('service')->andReturn($service);
        $cmd->handle();

        # publish
        $service = m::mock(PublishService::class);
        $cmd = m::mock(PublishCommand::class . '[argument, publish, service]');
        $cmd->shouldReceive('argument')->andReturn('publish');
        $cmd->shouldReceive('service')->andReturn($service);
        $cmd->shouldReceive('publish')->andReturnNull();
        $cmd->handle();

        # create-history-from-table
        $service = m::mock(PublishService::class);
        $service->shouldReceive('createHistoryFromTable')->once();
        $cmd = m::mock(PublishCommand::class . '[argument, service]');
        $cmd->shouldReceive('argument')->once()->with('action')->andReturn('create-history-from-table');
        $cmd->shouldReceive('service')->once()->andReturn($service);
        $cmd->handle();
    }

    /**
     * @covers \Belt\Core\Commands\PublishCommand::publish
     */
    public function testPublish()
    {
        $service = m::mock(PublishService::class);
        $service->shouldReceive('publish')->andReturnNull();
        $service->created = ['one', 'two', 'three'];
        $service->modified = ['one', 'two', 'three'];
        $service->ignored = ['one', 'two', 'three'];

        $cmd = m::mock(PublishCommand::class . '[info, warn]');
        $cmd->shouldReceive('info')->times(8)->andReturnNull();
        $cmd->shouldReceive('warn')->times(4)->andReturnNull();
        $cmd->publish($service);
    }

    /**
     * @covers \Belt\Core\Commands\PublishCommand::service
     */
    public function testService()
    {
        $cmd = m::mock(PublishCommand::class . '[option]');
        $cmd->shouldReceive('option')->with('prune')->andReturn(false);
        $cmd->shouldReceive('option')->with('force')->andReturn(false);
        $cmd->shouldReceive('option')->with('include')->andReturn('test');
        $cmd->shouldReceive('option')->with('exclude')->andReturn('something-else');
        $cmd->shouldReceive('option')->with('config')->andReturn(false);

        $this->assertInstanceOf(PublishService::class, $cmd->service());
    }
}
