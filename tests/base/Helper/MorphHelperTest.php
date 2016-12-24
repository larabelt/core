<?php

use Mockery as m;
use Ohio\Core\Base\Testing\OhioTestCase;
use Ohio\Core\Base\Helper\MorphHelper;
use Ohio\Core\User\User;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class MorphHelperTest extends OhioTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Core\Base\Helper\MorphHelper::map
     * @covers \Ohio\Core\Base\Helper\MorphHelper::type2Class
     * @covers \Ohio\Core\Base\Helper\MorphHelper::morph
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
