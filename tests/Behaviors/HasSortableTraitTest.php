<?php

use Belt\Core\Behaviors\HasSortableTrait;
use Illuminate\Database\Eloquent\Model;

class HasSortableTraitTest extends \PHPUnit_Framework_TestCase
{

    /**
     * covers \Belt\Core\Behaviors\HasSortableTraitStub::getBelongsToManyCaller
     */
    public function test()
    {
        $stub = new HasSortableTraitStub();
        $this->assertEquals('guessBelongsToManyRelation', $stub->getBelongsToManyCaller());
    }

}

class HasSortableTraitStub extends Model
{
    use HasSortableTrait;

    protected function guessBelongsToManyRelation()
    {
        return 'guessBelongsToManyRelation';
    }

}