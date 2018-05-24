<?php

use Mockery as m;
use Belt\Core\Commands\AlertCommand;
use Belt\Core\Services\AlertService;

class AlertCommandTest extends \PHPUnit\Framework\TestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Commands\AlertCommand::service
     * @covers \Belt\Core\Commands\AlertCommand::handle
     */
    public function test()
    {
        // service
        $cmd = new AlertCommand();
        $this->assertInstanceOf(AlertService::class, $cmd->service());

        // handle
        $service = m::mock(AlertService::class);
        $service->shouldReceive('cache')->once()->andReturnNull();
        $cmd = m::mock(AlertCommand::class . '[service]');
        $cmd->shouldReceive('service')->once()->andReturn($service);
        $cmd->handle();
    }

}
