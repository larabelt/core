<?php namespace Tests\Belt\Core\Unit\Services;

use Belt\Core\Services\AccessService;
use Belt\Core\Tests;
use Belt\Core\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Mockery as m;

class AccessServiceTest extends Tests\BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Services\AccessService::put
     * @covers \Belt\Core\Services\AccessService::map
     */
    public function test()
    {
        # put
        $this->assertFalse(array_has(AccessService::$permissions, 'bar.*'));
        $this->assertFalse(array_has(AccessService::$permissions, 'bar.foo'));
        AccessService::put('foo', 'bar');
        $this->assertTrue(array_has(AccessService::$permissions, 'bar.*'));
        $this->assertTrue(array_has(AccessService::$permissions, 'bar.foo'));

        # map (there is no authenticated user)
        $service = new AccessService();
        Auth::shouldReceive('user')->andReturn(false);
        $this->assertEquals([], $service->map());
    }

    /**
     * @covers \Belt\Core\Services\AccessService::map
     */
    public function test2()
    {
        # map (session.access already set)
        AccessService::put('foo', 'bar');

        Auth::shouldReceive('user')->andReturn(factory(User::class)->make(['is_super' => false]));

        Session::shouldReceive('get')->with('access', null)->andReturn(['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], (new AccessService())->map());
    }

    /**
     * @covers \Belt\Core\Services\AccessService::map
     */
    public function test3()
    {
        AccessService::$permissions = [];

        $user = m::mock(User::class);
        $user->shouldReceive('can')->with('*', 'users')->andReturn(false);
        $user->shouldReceive('can')->with('view', 'users')->andReturn(true);
        $user->shouldReceive('can')->with('*', 'roles')->andReturn(true);

        # map (build new access map)
        AccessService::put('view', 'users');
        AccessService::put('attach', 'roles');

        Auth::shouldReceive('user')->andReturn($user);

        $expectedMap = [
            'users' => [
                '*' => false,
                'view' => true,
            ],
            'roles' => [
                '*' => true,
            ]
        ];

        $this->assertEquals($expectedMap, (new AccessService())->map());
    }

}