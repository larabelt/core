<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Helpers\MorphHelper;
use Belt\Core\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class MorphHelperTest extends BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Helpers\MorphHelper::map
     * @covers \Belt\Core\Helpers\MorphHelper::type2Class
     * @covers \Belt\Core\Helpers\MorphHelper::type2QB
     * @covers \Belt\Core\Helpers\MorphHelper::morph
     */
    public function test()
    {
        $morphHelper = new MorphHelper();
        $morphMap = Relation::morphMap();

        # map
        $this->assertEquals($morphMap, $morphHelper->map());

        # type2Class
        $this->assertNull($morphHelper->type2Class('missing'));
        $this->assertEquals(User::class, $morphHelper->type2Class('users'));

        # type2QB
        $this->assertInstanceOf(Builder::class, $morphHelper->type2QB('teams'));

        # morph
        $qb = m::mock(Builder::class);
        $qb->shouldReceive('find')->with(1)->andReturn(new User());
        $morphHelper = m::mock(MorphHelper::class . '[type2QB]');
        $morphHelper->shouldReceive('type2QB')->with('users')->andReturn($qb);
        $morphHelper->shouldReceive('type2QB')->with('missing')->andReturnNull();
        $this->assertInstanceOf(User::class, $morphHelper->morph('users', 1));
        $this->assertNull($morphHelper->morph('missing', 1));
    }
}
