<?php namespace Tests\Belt\Core\Unit\Resources;

use Belt\Core\Resources\BaseResource;
use Belt\Core\Resources\Traits\HasGroup;
use Tests\Belt\Core\BeltTestCase;

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