<?php

use Mockery as m;
use Belt\Core\Commands\UpdateCommand;
use Belt\Core\Services\Update\UpdateService;
use Belt\Core\Testing\BeltTestCase;

class UpdateCommandTest extends BeltTestCase
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
        $cmd = m::mock(UpdateCommand::class . '[argument]');
        $cmd->shouldReceive('argument')->once()->with('package')->andReturn('core');
        $this->assertInstanceOf(UpdateService::class, $cmd->service());

        // handle
        $service = m::mock(UpdateService::class);
        $service->shouldReceive('run')->once()->andReturnNull();

        $cmd = m::mock(UpdateCommand::class . '[service,argument]');
        $cmd->shouldReceive('service')->once()->andReturn($service);
        $cmd->shouldReceive('argument')->once()->with('update')->andReturn('foo');
        $cmd->handle();
    }

}
