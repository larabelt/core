<?php namespace Tests\Belt\Core\Unit\Resources;

use Belt\Core\Resources\BaseResource;
use Belt\Core\Resources\Traits\HasSectionable;
use Belt\Core\Tests\BeltTestCase;

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