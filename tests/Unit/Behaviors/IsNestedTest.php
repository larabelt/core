<?php namespace Tests\Belt\Core\Unit\Behaviors;

use Belt\Core\Behaviors\IsNested;
use Belt\Core\Behaviors\IsNestedInterface;
use Belt\Core\Tests;
use Illuminate\Database\Eloquent\Model;
use Mockery as m;

class IsNestedTest extends Tests\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Behaviors\IsNested::getHierarchyAttribute
     * @covers \Belt\Core\Behaviors\IsNested::getNestedName
     * @covers \Belt\Core\Behaviors\IsNested::getNestedNameAttribute
     * @covers \Belt\Core\Behaviors\IsNested::getNestedNames
     * @covers \Belt\Core\Behaviors\IsNested::getNestedSlugs
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
        $this->assertEquals(['One', 'Two', 'Three', 'Four'], $nested->getNestedNames());
        $this->assertEquals(['one', 'two', 'three', 'four'], $nested->getNestedSlugs());
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

class IsNestedStub extends Model
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