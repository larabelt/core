<?php namespace Tests\Belt\Core\Unit\Resources;

use Belt\Core\Resources\BaseResource;
use Belt\Core\Resources\Traits\HasTranslatable;
use Tests\Belt\Core\BeltTestCase;

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