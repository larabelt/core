<?php namespace Tests\Belt\Core\Unit\Behaviors;

use Belt\Core\Behaviors\IsSearchable;
use Tests\Belt\Core;
use Belt\Core\User;
use Mockery as m;

class IsSearchableTest extends \Tests\Belt\Core\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Behaviors\IsSearchable::toSearchableArray
     * @covers \Belt\Core\Behaviors\IsSearchable::__toSearchableArray
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

class IsSearchableStub extends \Tests\Belt\Core\Base\BaseModelStub
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

    public function relationsToArray()
    {
        User::unguard();
        $user = factory(User::class)->make();

        return [
            'user' => $user->toArray(),
        ];
    }

}