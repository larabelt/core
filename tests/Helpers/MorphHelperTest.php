<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Helpers\MorphHelper;
use Belt\Core\User;
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
     * @covers \Belt\Core\Helpers\MorphHelper::morph
     */
    public function test()
    {
        $userRepo = m::mock('overload:' . User::class);
        $userRepo->shouldReceive('find')->with(1)->andReturn(new User());

        $morphHelper = new MorphHelper();
        $morphMap = Relation::morphMap();

        # map
        $this->assertEquals($morphMap, $morphHelper->map());

        # type2Class
        $this->assertNull($morphHelper->type2Class('missing'));
        $this->assertEquals(User::class, $morphHelper->type2Class('users'));

        # morph
        $this->assertInstanceOf(User::class, $morphHelper->morph('users', 1));
        $this->assertNull($morphHelper->morph('missing', 1));
    }
}
