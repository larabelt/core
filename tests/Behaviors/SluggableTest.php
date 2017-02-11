<?php

use Illuminate\Database\Eloquent\Model;

class SluggableTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\Behaviors\Sluggable::__toString
     * @covers \Ohio\Core\Behaviors\Sluggable::setNameAttribute
     * @covers \Ohio\Core\Behaviors\Sluggable::setSlugAttribute
     * @covers \Ohio\Core\Behaviors\Sluggable::slugify
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
    implements \Ohio\Core\Behaviors\SluggableInterface
{
    use \Ohio\Core\Behaviors\Sluggable;
}