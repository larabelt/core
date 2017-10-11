<?php

use Mockery as m;
use Belt\Core\Behaviors\IsNested;
use Belt\Core\Behaviors\IsNestedInterface;
use Belt\Core\Testing;

class IsNestedTest extends Testing\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Behaviors\IsNested::getHierarchyAttribute
     * @covers \Belt\Core\Behaviors\IsNested::getNestedName
     * @covers \Belt\Core\Behaviors\IsNested::getNestedNameAttribute
     */
    public function test()
    {
        # getHierarchyAttribute
        $nested = $this->getNestedWithAncestors();
        $hierarchy = $nested->getHierarchyAttribute();
        $this->assertEquals(4, count($hierarchy));
        $this->assertEquals('four', array_get($hierarchy, '3.slug'));

        # getNestedName
        # getNestedNameAttribute
        $nested = $this->getNestedWithAncestors();
        $this->assertEquals('One > Two > Three > Four', $nested->nested_name);
    }

    public function getNestedWithAncestors()
    {
        IsNestedStub::unguard();
        $ancestors = new \Illuminate\Database\Eloquent\Collection();
        $ancestors->push(new IsNestedStub([
            'id' => 1,
            'name' => 'One',
            'slug' => 'one',
        ]));
        $ancestors->push(new IsNestedStub([
            'id' => 2,
            'name' => 'Two',
            'slug' => 'two',
        ]));
        $ancestors->push(new IsNestedStub([
            'id' => 3,
            'name' => 'Three',
            'slug' => 'three',
        ]));
        $nested = m::mock(IsNestedStub::class . '[getAncestors]');
        $nested->shouldReceive('getAncestors')->andReturn($ancestors);
        $nested->id = 4;
        $nested->name = 'Four';
        $nested->slug = 'four';

        return $nested;
    }

}

class IsNestedStub extends Testing\BaseModelStub
    implements IsNestedInterface
{
    use IsNested;

    protected $attributes = [
        'foo' => 'bar',
    ];

    protected $appends = ['test'];

    public function getTestAttribute()
    {
        return 'bar2';
    }

}