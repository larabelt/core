<?php

use Mockery as m;
use Belt\Core\Commands\BeltCommand;
use Belt\Core\Testing\BeltTestCase;

class BeltCommandTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Commands\BeltCommand::handle
     */
    public function testHandle()
    {

        # handle -> publish
        $cmd = m::mock(BeltCommand::class . '[argument,options,publish]');
        $cmd->shouldReceive('argument')->once()->andReturn('publish');
        $cmd->shouldReceive('options')->once()->andReturn([]);
        $cmd->shouldReceive('publish')->once()->andReturn();
        $cmd->handle();

        # handle -> seed
        $cmd = m::mock(BeltCommand::class . '[argument,seed]');
        $cmd->shouldReceive('argument')->once()->andReturn('seed');
        $cmd->shouldReceive('seed')->once()->andReturn();
        $cmd->handle();

        # handle -> refresh
        $cmd = m::mock(BeltCommand::class . '[argument,refresh]');
        $cmd->shouldReceive('argument')->once()->andReturn('refresh');
        $cmd->shouldReceive('refresh')->once()->andReturn();
        $cmd->handle();

    }

    /**
     * @covers \Belt\Core\Commands\BeltCommand::seed
     */
    public function testSeed()
    {
        $cnt = count(app('belt')->seeders());

        $cmd = m::mock(BeltCommand::class . '[info,call]');
        $cmd->shouldReceive('info')->times($cnt);
        $cmd->shouldReceive('call')->times($cnt);
        $cmd->seed();
    }

    /**
     * @covers \Belt\Core\Commands\BeltCommand::refresh
     */
    public function testRefresh()
    {
        $cmd = m::mock(BeltCommand::class . '[publish,info,call,seed,process]');
        $cmd->shouldReceive('publish')->with(['force' => true])->once();
        $cmd->shouldReceive('info')->once()->with('migrate:refresh');
        $cmd->shouldReceive('call')->once()->with('migrate:refresh');
        $cmd->shouldReceive('seed')->once();
        $cmd->refresh();
    }

    /**
     * @covers \Belt\Core\Commands\BeltCommand::publish
     */
    public function testPublish()
    {
        $cnt = count(app('belt')->publish());

        $cmd = m::mock(BeltCommand::class . '[info,call,process]');
        $cmd->shouldReceive('info')->times($cnt);
        $cmd->shouldReceive('call')->times($cnt);
        $cmd->shouldReceive('process')->once()->with('composer dumpautoload');
        $cmd->publish();
    }
}
