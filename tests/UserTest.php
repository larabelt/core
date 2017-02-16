<?php

use Belt\Core\Testing\BeltTestCase;
use Belt\Core\User;
use Belt\Core\Role;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\User::__toString
     * @covers \Belt\Core\User::setEmailAttribute
     * @covers \Belt\Core\User::setIsVerifiedAttribute
     * @covers \Belt\Core\User::setIsActiveAttribute
     * @covers \Belt\Core\User::setFirstNameAttribute
     * @covers \Belt\Core\User::setLastNameAttribute
     * @covers \Belt\Core\User::setMiAttribute
     * @covers \Belt\Core\User::setPasswordAttribute
     * @covers \Belt\Core\User::setUsernameAttribute
     * @covers \Belt\Core\User::roles
     * @covers \Belt\Core\User::hasRole
     * @covers \Belt\Core\User::getFullNameAttribute
     */
    public function test()
    {
        $user = factory(User::class)->make();
        $role = factory(Role::class)->make(['name' => 'test']);

        User::unguard();

        $user->email = ' TEST@TEST.COM ';
        $user->is_verified = 1;
        $user->is_active = 1;
        $user->first_name = ' test ';
        $user->last_name = ' test ';
        $user->mi = ' test ';
        $user->password = ' test ';
        $user->username = ' TEST ';

        $attributes = $user->getAttributes();

        # roles relationship
        $this->assertInstanceOf(BelongsToMany::class, $user->roles());
        $user->roles->add(factory(Role::class)->make(['name' => 'test']));
        $this->assertEquals(1, $user->roles->count());

        # hasRole
        $this->assertTrue($user->hasRole('test'));
        $this->assertFalse($user->hasRole('other-role'));
        $this->assertFalse($user->hasRole('super'));
        $user->roles->add(factory(Role::class)->make(['name' => 'super']));
        $this->assertEquals(2, $user->roles->count());
        $user->is_super = 1;
        $this->assertTrue($user->hasRole('whatever'));

        # setters
        $this->assertEquals('test@test.com', $user->email);
        $this->assertEquals('test@test.com', $user->__toString());
        $this->assertEquals(true, $attributes['is_verified']);
        $this->assertEquals(true, $attributes['is_active']);
        $this->assertEquals('TEST', $attributes['last_name']);
        $this->assertEquals('TEST', $attributes['first_name']);
        $this->assertEquals('T', $attributes['mi']);
        $this->assertTrue(Hash::check('test', $attributes['password']));
        $this->assertEquals('test', $attributes['username']);

        # getters
        $this->assertEquals('TEST T. TEST', $user->fullName);
        $user->mi = null;
        $this->assertEquals('TEST TEST', $user->fullName);

//        # Authenticatable functions
//        $user->id = 1;
//        $user->setRememberToken('test');
//        $attributes = $user->getAttributes();
//        $this->assertEquals('test', $attributes['remember_token']);
//        $this->assertNotEmpty($user->getAuthIdentifierName());
//        $this->assertNotEmpty($user->getAuthIdentifier());
//        $this->assertNotEmpty($user->getAuthPassword());
//        $this->assertNotEmpty($user->getRememberToken());
//        $this->assertNotEmpty($user->getRememberTokenName());
//        $this->assertEquals('test@test.com', $user->getReminderEmail());

    }

}