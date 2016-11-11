<?php

use Mockery as m;

use Ohio\Core\Base\Commands\TestDBCommand;
use Ohio\Core\Base\Testing\OhioTestCase;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;

class TestDBCommandTest extends OhioTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Core\Base\Commands\TestDBCommand::disk
     * @covers \Ohio\Core\Base\Commands\TestDBCommand::fire
     */
    public function testHandle()
    {

        $cmd = new TestDBCommand();

        # disk
        $this->assertInstanceOf(Filesystem::class, $cmd->disk());

        # fire (option.env is not testing)
        $cmd = $this->getMockBuilder(TestDBCommand::class)
            ->setMethods(['option', 'info'])
            ->getMock();
        $cmd->expects($this->once())->method('option')->willReturn('production');
        $cmd->expects($this->once())->method('info')->willReturn('error');
        $cmd->fire();

        # fire (option.env is testing)

        $disk = $this->mockDisk();
        $cmd = $this->getMockBuilder(TestDBCommand::class)
            ->setMethods(['option', 'disk', 'call'])
            ->getMock();
        $cmd->expects($this->once())->method('option')->willReturn('testing');
        $cmd->expects($this->any())->method('disk')->willReturn($disk);
        $cmd->expects($this->any())->method('call')->willReturn(null);

        $cmd->fire();

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
