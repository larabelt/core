<?php

use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Resources\BaseResource;
use Belt\Core\Resources\Traits\HasDisplay;

class ResourcesTraitsHasDisplayTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Resources\Traits\HasDisplay::setDisplay
     * @covers \Belt\Core\Resources\Traits\HasDisplay::getDisplay
     */
    public function test()
    {
        $resource = StubResourcesTraitsHasDisplayTest::make('foo');

        # set/get display
        $resource->setDisplay('test');
        $this->assertEquals('test', $resource->getDisplay());
    }

}

class StubResourcesTraitsHasDisplayTest extends BaseResource
{
    use HasDisplay;
}