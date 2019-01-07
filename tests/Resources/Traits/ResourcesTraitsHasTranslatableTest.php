<?php

use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Resources\BaseResource;
use Belt\Core\Resources\Traits\HasTranslatable;

class ResourcesTraitsHasTranslatableTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Resources\Traits\HasTranslatable::setTranslatable
     * @covers \Belt\Core\Resources\Traits\HasTranslatable::getTranslatable
     */
    public function test()
    {
        $resource = StubResourcesTraitsHasTranslatableTest::make('foo');

        # set/get translatable
        $resource->setTranslatable('test');
        $this->assertEquals('test', $resource->getTranslatable());
    }

}

class StubResourcesTraitsHasTranslatableTest extends BaseResource
{
    use HasTranslatable;
}