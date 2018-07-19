<?php

use Mockery as m;

use Belt\Core\Services\Update\UpdateService;
use Belt\Core\Testing;

class UpdateServiceTest extends Testing\BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Services\Update\UpdateService::__construct
     * @covers \Belt\Core\Services\Update\UpdateService::registerUpdates
     * @covers \Belt\Core\Services\Update\UpdateService::register
     * @covers \Belt\Core\Services\Update\UpdateService::run
     * @covers \Belt\Core\Services\Update\UpdateService::runUpdate
     */
    public function test()
    {

        $path = __DIR__ . '/updates';

        # __construct
        $service = new UpdateService(['path' => $path]);
        $service->registerUpdates();
        $this->assertEquals($path, $service->path);

        # update
        UpdateService::register('foo', function ($service) {
            $service->runUpdate('foo');
        });

        //$service->run(['foo', 'bar']);
    }

}