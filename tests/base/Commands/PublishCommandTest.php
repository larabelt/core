<?php

use Ohio\Core\Base\Commands\PublishCommand;
use Ohio\Core\Base\Services\PublishService;

class PublishCommandTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\Base\Commands\PublishCommand::handle
     */
    public function testHandle()
    {

        $cmd = $this->getMockBuilder(PublishCommand::class)
            ->setMethods(['getService', 'info', 'warn'])
            ->getMock();

        $service = $this->getMockBuilder(PublishService::class)
            ->setMethods(['publish'])
            ->getMock();

        $service->created = ['one', 'two', 'three'];
        $service->modified = ['one', 'two', 'three'];
        $service->ignored = ['one', 'two', 'three'];

        $service->expects($this->once())->method('publish');

        $cmd->expects($this->once())->method('getService')->willReturn($service);
        $cmd->expects($this->exactly(8))->method('info');
        $cmd->expects($this->exactly(4))->method('warn');

        $cmd->handle();
    }

    /**
     * @covers \Ohio\Core\Base\Commands\PublishCommand::getService
     */
    public function testGetService()
    {

        $cmd = $this->getMockBuilder(PublishCommand::class)
            ->setMethods(['option'])
            ->getMock();

        $cmd->expects($this->once())->method('option')->willReturn(false);

        $service = $cmd->getService();

        $this->assertInstanceOf(PublishService::class, $service);

    }
}
