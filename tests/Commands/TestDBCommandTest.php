<?php

use Mockery as m;

use Belt\Core\Commands\TestDBCommand;
use Belt\Core\Testing\BeltTestCase;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;

class TestDBCommandTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Commands\TestDBCommand::disk
     * @covers \Belt\Core\Commands\TestDBCommand::handle
     */
    public function testHandle()
    {

        $cmd = new TestDBCommand();

        # disk
        $this->assertInstanceOf(Filesystem::class, $cmd->disk());

        # fire (option.env is testing)
        $disk = $this->mockDisk();
        $cmd = $this->getMockBuilder(TestDBCommand::class)
            ->setMethods(['disk', 'call'])
            ->getMock();
        $cmd->expects($this->any())->method('disk')->willReturn($disk);
        $cmd->expects($this->any())->method('call')->willReturn(null);

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
