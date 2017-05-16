<?php

use Mockery as m;
use Belt\Core\Behaviors\IsSearchable;
use Belt\Core\Testing;

class IsSearchableTest extends Testing\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Behaviors\IsSearchable::toSearchableArray
     */
    public function test()
    {
        # init
        IsSearchableStub::unguard();
        $searchable = new IsSearchableStub();

        # toSearchableArray
        $array = $searchable->toArray();
        $this->assertEquals('bar', array_get($array, 'foo'));
        $this->assertEquals('bar2', array_get($array, 'test'));
        $array = $searchable->toSearchableArray();
        $this->assertEquals('bar', array_get($array, 'foo'));
        $this->assertNull(array_get($array, 'test'));
    }

}

class IsSearchableStub extends Testing\BaseModelStub
{
    use IsSearchable;

    protected $attributes = [
        'foo' => 'bar',
    ];

    protected $appends = ['test'];

    public function getTestAttribute()
    {
        return 'bar2';
    }

}