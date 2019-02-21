<?php namespace Tests\Belt\Core\Unit\Resources;

use Belt\Core\Resources\BaseResource;
use Belt\Core\Resources\Traits\HasDriver;
use Belt\Core\Tests\BeltTestCase;

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