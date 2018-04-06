<?php

use Mockery as m;
use Belt\Core\Commands\UpdateCommand;
use Belt\Core\Services\Update\UpdateService;

class UpdateCommandTest extends \PHPUnit_Framework_TestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Commands\UpdateCommand::service
     * @covers \Belt\Core\Commands\UpdateCommand::handle
     */
    public function test()
    {
        // service
        $cmd = new UpdateCommand();
        $this->assertInstanceOf(UpdateService::class, $cmd->service());

        // handle
        $service = m::mock(UpdateService::class);
        $service->shouldReceive('registerUpdates')->once()->andReturnNull();
        $service->shouldReceive('run')->once()->andReturnNull();
        $cmd = m::mock(UpdateCommand::class . '[service,argument]');
        $cmd->shouldReceive('service')->once()->andReturn($service);
        $cmd->shouldReceive('argument')->once()->with('update')->andReturn('foo');
        $cmd->handle();
    }

}
