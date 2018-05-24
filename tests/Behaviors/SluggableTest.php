<?php

use Illuminate\Database\Eloquent\Model;

class SluggableTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @covers \Belt\Core\Behaviors\Sluggable::__toString
     * @covers \Belt\Core\Behaviors\Sluggable::setNameAttribute
     * @covers \Belt\Core\Behaviors\Sluggable::setSlugAttribute
     * @covers \Belt\Core\Behaviors\Sluggable::slugify
     */
    public function test()
    {
        // init
        $sluggable = new SluggableStub();
        $this->assertNull($sluggable->slug);
        $sluggable->name = ' TEST ';

        # setNameAttribute
        $this->assertEquals('TEST', $sluggable->name);

        # __toString
        $this->assertEquals($sluggable->name, $sluggable->__toString());

        # slugify
        # setSlugAttribute
        $sluggable->slugify();
        $this->assertEquals('test', $sluggable->slug);
    }

}

class SluggableStub extends Model
    implements \Belt\Core\Behaviors\SluggableInterface
{
    use \Belt\Core\Behaviors\Sluggable;
}