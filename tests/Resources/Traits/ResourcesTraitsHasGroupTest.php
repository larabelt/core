<?php

use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Resources\BaseResource;
use Belt\Core\Resources\Traits\HasGroup;

class ResourcesTraitsHasGroupTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Resources\Traits\HasGroup::setGroup
     * @covers \Belt\Core\Resources\Traits\HasGroup::getGroup
     */
    public function test()
    {
        $resource = StubResourcesTraitsHasGroupTest::make('foo');

        # set/get group
        $resource->setGroup('test');
        $this->assertEquals('test', $resource->getGroup());
    }

}

class StubResourcesTraitsHasGroupTest extends BaseResource
{
    use HasGroup;
}