<?php

use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Resources\BaseResource;
use Belt\Core\Resources\Traits\HasSectionable;

class ResourcesTraitsHasSectionableTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Resources\Traits\HasSectionable::setSectionable
     * @covers \Belt\Core\Resources\Traits\HasSectionable::isSectionable
     */
    public function test()
    {
        $resource = StubResourcesTraitsHasSectionableTest::make('foo');

        # set/is sectionable
        $resource->setSectionable('test');
        $this->assertEquals('test', $resource->isSectionable());
    }

}

class StubResourcesTraitsHasSectionableTest extends BaseResource
{
    use HasSectionable;
}