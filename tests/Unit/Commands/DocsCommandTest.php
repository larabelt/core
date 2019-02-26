<?php namespace Tests\Belt\Core\Unit\Commands;

use Belt\Core\Commands\DocsCommand;
use Belt\Core\Services\DocsService;
use Tests\Belt\Core;
use Mockery as m;

class DocsCommandTest extends \Tests\Belt\Core\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Commands\DocsCommand::handle
     */
    public function testHandle()
    {
        $service = m::mock(DocsService::class);
        $service->shouldReceive('generate')->once();
        $cmd = m::mock(DocsCommand::class . '[service,argument,option]');
        $cmd->shouldReceive('argument')->once()->with('action')->andReturn('generate');
        $cmd->shouldReceive('option')->once()->with('doc_version')->andReturn('2.0');
        $cmd->shouldReceive('service')->andReturn($service);
        $cmd->handle();
    }

}