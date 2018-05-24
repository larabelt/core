<?php

use Belt\Core\Behaviors\HasSortableTrait;
use Illuminate\Database\Eloquent\Model;

class HasSortableTraitTest extends \PHPUnit\Framework\TestCase
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