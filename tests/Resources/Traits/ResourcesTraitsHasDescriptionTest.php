<?php

use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Resources\BaseResource;
use Belt\Core\Resources\Traits\HasDescription;

class ResourcesTraitsHasDescriptionTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Resources\Traits\HasDescription::setDescription
     * @covers \Belt\Core\Resources\Traits\HasDescription::getDescription
     */
    public function test()
    {
        $resource = StubResourcesTraitsHasDescriptionTest::make('foo');

        # set/get description
        $resource->setDescription('test');
        $this->assertEquals('test', $resource->getDescription());
    }

}

class StubResourcesTraitsHasDescriptionTest extends BaseResource
{
    use HasDescription;
}