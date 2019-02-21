<?php namespace Tests\Belt\Core\Unit\Commands;

use Belt\Core\Commands\BackupCommand;
use Belt\Core\Services\BackupService;
use Mockery as m;

class BackupCommandTest extends \PHPUnit\Framework\TestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Commands\BackupCommand::service
     * @covers \Belt\Core\Commands\BackupCommand::handle
     */
    public function test()
    {
        // service
        $cmd = new BackupCommand();
        $this->assertInstanceOf(BackupService::class, $cmd->service());

        // handle
        $service = m::mock(BackupService::class . '[run]');
        $service->shouldReceive('run')->with('default')->andReturnNull();

        $cmd = m::mock(BackupCommand::class . '[service,option]');
        $cmd->shouldReceive('option')->with('group')->andReturn('default');
        $cmd->shouldReceive('service')->once()->andReturn($service);
        $cmd->handle();
    }

}
