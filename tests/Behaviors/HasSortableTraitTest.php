<?php

use Belt\Core\Behaviors\HasSortableTrait;
use Illuminate\Database\Eloquent\Model;

class HasSortableTraitTest extends \PHPUnit_Framework_TestCase
{

    public function test()
    {
        $stub = new HasSortableTraitStub();
    }

}

class HasSortableTraitStub extends Model
{
    use HasSortableTrait;

}