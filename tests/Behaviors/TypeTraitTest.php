<?php

use Belt\Core\Behaviors\TypeInterface;
use Belt\Core\Behaviors\TypeTrait;
use Illuminate\Database\Eloquent\Model;

class TypeTraitTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @covers \Belt\Core\Behaviors\TypeTrait::getTypeAttribute
     * @covers \Belt\Core\Behaviors\TypeTrait::getMorphClassAttribute
     */
    public function test()
    {
        $stub = new TypeTraitStub();

        # type
        $this->assertEquals($stub->type, 'tests');

        # morphClass
        $this->assertEquals($stub->morph_class, 'tests');
    }

}

class TypeTraitStub extends Model
    implements TypeInterface
{
    use TypeTrait;

    public function getTable()
    {
        return 'tests';
    }

    public function getMorphClass()
    {
        return 'tests';
    }
}