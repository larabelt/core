<?php

use Mockery as m;

use Belt\Core\Commands\TestCommand;
use Belt\Core\Testing\BeltTestCase;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;

class TestCommandTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Commands\TestCommand::disk
     * @covers \Belt\Core\Commands\TestCommand::handle
     * @covers \Belt\Core\Commands\TestCommand::responses
     * @covers \Belt\Core\Commands\TestCommand::buildTestingDB
     */
    public function testHandle()
    {

        $cmd = new TestCommand();

        # disk
        $this->assertInstanceOf(Filesystem::class, $cmd->disk());

        # fire (option.env is testing)
        $disk = $this->mockDisk();

        $cmd = m::mock(TestCommand::class . '[argument,option,disk,call]');
        $cmd->shouldReceive('argument')->with('action')->andReturn('db');
        $cmd->shouldReceive('option')->with('types')->andReturn();
        $cmd->shouldReceive('disk')->andReturn($disk);
        $cmd->shouldReceive('call')->andReturn();

        $cmd->handle();
    }

    private function mockDisk()
    {
        $disk = m::mock(FilesystemAdapter::class);
        $disk->shouldReceive('delete')->andReturn(true);
        $disk->shouldReceive('copy')->andReturn(true);

        $disk->shouldReceive('files')->andReturn([
            '/path/to/src/Seeder1',
            '/path/to/src/Seeder2',
            '/path/to/src/Seeder3',
        ]);

        return $disk;
    }

}
