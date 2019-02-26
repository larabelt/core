<?php namespace Tests\Belt\Core\Unit;

use Tests\Belt\Core\BeltTestCase;
use Belt\Core\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Hash;
use Mockery as m;

class UserTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\User::__toString
     * @covers \Belt\Core\User::teams
     * @covers \Belt\Core\User::setEmailAttribute
     * @covers \Belt\Core\User::setIsVerifiedAttribute
     * @covers \Belt\Core\User::setIsActiveAttribute
     * @covers \Belt\Core\User::setFirstNameAttribute
     * @covers \Belt\Core\User::setLastNameAttribute
     * @covers \Belt\Core\User::setMiAttribute
     * @covers \Belt\Core\User::setPasswordAttribute
     * @covers \Belt\Core\User::setUsernameAttribute
     * @covers \Belt\Core\User::getFullNameAttribute
     * @covers \Belt\Core\User::setIsOptedInAttribute
     */
    public function test()
    {
        $user = factory(User::class)->make();

        User::unguard();

        $user->email = ' TEST@TEST.COM ';
        $user->is_verified = 1;
        $user->is_active = 1;
        $user->is_opted_in = 1;
        $user->first_name = ' test ';
        $user->last_name = ' test ';
        $user->mi = ' test ';
        $user->password = ' test ';
        $user->username = ' TEST ';

        $attributes = $user->getAttributes();

        # teams
        $this->assertInstanceOf(BelongsToMany::class, $user->teams());

        # setters
        $this->assertEquals('test@test.com', $user->email);
        $this->assertEquals('test@test.com', $user->__toString());
        $this->assertEquals(true, $attributes['is_verified']);
        $this->assertEquals(true, $attributes['is_active']);
        $this->assertEquals(true, $attributes['is_opted_in']);
        $this->assertEquals('TEST', $attributes['last_name']);
        $this->assertEquals('TEST', $attributes['first_name']);
        $this->assertEquals('T', $attributes['mi']);
        $this->assertTrue(Hash::check('test', $attributes['password']));
        $this->assertEquals('test', $attributes['username']);

        # getters
        $this->assertEquals('TEST T. TEST', $user->fullName);
        $user->mi = null;
        $this->assertEquals('TEST TEST', $user->fullName);

//        # isAllowed (no extra rights)
//        $user = factory(User::class)->make();
//        $permissible = m::mock(PermissibleService::class);
//        $permissible->shouldReceive('hasRole')->with($user, 'admin')->andReturn(false);
//        $user->permissible = $permissible;
//        $this->assertFalse($user->isAllowed('foo'));
//
//        # isAllowed (super)
//        $user = factory(User::class)->make();
//        $this->assertTrue($user->isAllowed('foo'));
//
//        # isAllowed (admin)
//        $user = factory(User::class)->make();
//        $permissible = m::mock(PermissibleService::class);
//        $permissible->shouldReceive('hasRole')->with($user, 'admin')->andReturn(true);
//        $user->permissible = $permissible;
//        $this->assertTrue($user->isAllowed('foo'));
//
//        # isAllowed (member of team w/admin)
//        $user = factory(User::class)->make();
//        $team = factory(Team::class)->make();
//        $user->teams->add($team);
//        $permissible = m::mock(PermissibleService::class);
//        $permissible->shouldReceive('hasRole')->with($user, 'admin')->andReturn(false);
//        $permissible->shouldReceive('hasRole')->with($team, 'admin')->andReturn(true);
//        $user->permissible = $permissible;
//        $this->assertTrue($user->isAllowed('foo'));
//
//        # isAllowed (member of team w/ability)
//        $user = factory(User::class)->make();
//        $team = factory(Team::class)->make();
//        $user->teams->add($team);
//        $permissible = m::mock(PermissibleService::class);
//        $permissible->shouldReceive('hasRole')->with($user, 'admin')->andReturn(false);
//        $permissible->shouldReceive('hasRole')->with($team, 'admin')->andReturn(false);
//        $permissible->shouldReceive('isAllowed')->with($team, 'foo', null)->andReturn(true);
//        $user->permissible = $permissible;
//        $this->assertTrue($user->isAllowed('foo'));

    }

}