<?php

use Illuminate\Database\Eloquent\Model;
use Ohio\Core\Behaviors\SluggableTrait;

class SluggableTraitTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\Behaviors\SluggableTrait::__toString
     * @covers \Ohio\Core\Behaviors\SluggableTrait::setNameAttribute
     * @covers \Ohio\Core\Behaviors\SluggableTrait::setSlugAttribute
     * @covers \Ohio\Core\Behaviors\SluggableTrait::slugify
     */
    public function test()
    {
        // init
        $sluggable = new SluggableTraitStub();
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

class SluggableTraitStub extends Model
{
    use SluggableTrait;
}