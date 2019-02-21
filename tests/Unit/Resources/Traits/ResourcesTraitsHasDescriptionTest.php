<?php namespace Tests\Belt\Core\Unit\Resources;

use Belt\Core\Resources\BaseResource;
use Belt\Core\Resources\Traits\HasDescription;
use Belt\Core\Tests\BeltTestCase;

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