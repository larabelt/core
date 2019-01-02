<?php

use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Resources\BaseResource;
use Belt\Core\Resources\Traits\HasDriver;

class ResourcesTraitsHasDriverTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Resources\Traits\HasDriver::setDriver
     * @covers \Belt\Core\Resources\Traits\HasDriver::getDriver
     */
    public function test()
    {
        $resource = StubResourcesTraitsHasDriverTest::make('foo');

        # set/get driver
        $resource->setDriver('test');
        $this->assertEquals('test', $resource->getDriver());
    }

}

class StubResourcesTraitsHasDriverTest extends BaseResource
{
    use HasDriver;
}