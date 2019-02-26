<?php namespace Tests\Belt\Core\Unit\Services;

use Belt\Core\Services\Update\UpdateService;
use Tests\Belt\Core;

class UpdateServiceTest extends \Tests\Belt\Core\BeltTestCase
{
    /**
     * @covers \Belt\Core\Services\Update\UpdateService::__construct
     * @covers \Belt\Core\Services\Update\UpdateService::registerUpdates
     * @covers \Belt\Core\Services\Update\UpdateService::registerUpdate
     * @covers \Belt\Core\Services\Update\UpdateService::run
     * @covers \Belt\Core\Services\Update\UpdateService::runUpdate
     * @covers \Belt\Core\Services\Update\UpdateService::getUpdateClass
     * @covers \Belt\Core\Services\Update\UpdateService::getUpdateKey
     */
    public function test()
    {
        app('belt')->addPackage('test', ['dir' => __DIR__]);

        $service = new UpdateService(['package' => 'test']);

        $this->assertEquals('test', $service->packageKey);

        $this->assertEquals('foo', $service->run(['foo', 'bar']));

        $this->assertNull($service->run('bar'));

    }

}