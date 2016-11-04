<?php

use Illuminate\Database\Eloquent\Model;
use Ohio\Core\Base\Behaviors\SluggableTrait;

class SluggableTraitTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\Base\Behaviors\SluggableTrait::setNameAttribute
     * @covers \Ohio\Core\Base\Behaviors\SluggableTrait::setSlugAttribute
     * @covers \Ohio\Core\Base\Behaviors\SluggableTrait::slugify
     */
    public function test()
    {
        $sluggable = new SluggableTraitStub();

        $this->assertNull($sluggable->slug);
        $sluggable->name = ' TEST ';
        $this->assertEquals('TEST', $sluggable->name);
        $sluggable->slugify();
        $this->assertEquals('test', $sluggable->slug);
    }

}

class SluggableTraitStub extends Model
{
    use SluggableTrait;
}