<?php

use Ohio\Core\Base\Testing\OhioTestCase;
use Ohio\Core\Team\Team;
use Ohio\Core\Role\Role;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TeamTest extends OhioTestCase
{
    /**
     * @covers \Ohio\Core\Team\Team::__toString
     * @covers \Ohio\Core\Team\Team::setEmailAttribute
     * @covers \Ohio\Core\Team\Team::setIsVerifiedAttribute
     * @covers \Ohio\Core\Team\Team::setIsActiveAttribute
     * @covers \Ohio\Core\Team\Team::setFirstNameAttribute
     * @covers \Ohio\Core\Team\Team::setLastNameAttribute
     * @covers \Ohio\Core\Team\Team::setMiAttribute
     * @covers \Ohio\Core\Team\Team::setPasswordAttribute
     * @covers \Ohio\Core\Team\Team::setTeamnameAttribute
     * @covers \Ohio\Core\Team\Team::getAuthIdentifierName
     * @covers \Ohio\Core\Team\Team::getAuthIdentifier
     * @covers \Ohio\Core\Team\Team::getAuthPassword
     * @covers \Ohio\Core\Team\Team::getRememberToken
     * @covers \Ohio\Core\Team\Team::setRememberToken
     * @covers \Ohio\Core\Team\Team::getRememberTokenName
     * @covers \Ohio\Core\Team\Team::getReminderEmail
     * @covers \Ohio\Core\Team\Team::roles
     * @covers \Ohio\Core\Team\Team::hasRole
     */
    public function test()
    {
        $team = factory(Team::class)->make();
        $role = factory(Role::class)->make(['name' => 'test']);

        Team::unguard();

        $team->email = ' TEST@TEST.COM ';
        $team->is_verified = 1;
        $team->is_active = 1;
        $team->first_name = ' test ';
        $team->last_name = ' test ';
        $team->mi = ' test ';
        $team->password = ' test ';
        $team->teamname = ' TEST ';

        $attributes = $team->getAttributes();

        # roles relationship
        $this->assertInstanceOf(BelongsToMany::class, $team->roles());
        $team->roles->add(factory(Role::class)->make(['name' => 'test']));
        $this->assertEquals(1, $team->roles->count());

        # hasRole
        $this->assertTrue($team->hasRole('test'));
        $this->assertFalse($team->hasRole('other-role'));
        $this->assertFalse($team->hasRole('super'));
        $team->roles->add(factory(Role::class)->make(['name' => 'super']));
        $this->assertEquals(2, $team->roles->count());
        $this->assertTrue($team->hasRole('super'));

        # setters
        $this->assertEquals('test@test.com', $team->email);
        $this->assertEquals('test@test.com', $team->__toString());
        $this->assertEquals(true, $attributes['is_verified']);
        $this->assertEquals(true, $attributes['is_active']);
        $this->assertEquals('TEST', $attributes['last_name']);
        $this->assertEquals('TEST', $attributes['first_name']);
        $this->assertEquals('T', $attributes['mi']);
        $this->assertTrue(Hash::check('test', $attributes['password']));
        $this->assertEquals('test', $attributes['teamname']);

        # Authenticatable functions
        $team->id = 1;
        $team->setRememberToken('test');
        $attributes = $team->getAttributes();
        $this->assertEquals('test', $attributes['remember_token']);
        $this->assertNotEmpty($team->getAuthIdentifierName());
        $this->assertNotEmpty($team->getAuthIdentifier());
        $this->assertNotEmpty($team->getAuthPassword());
        $this->assertNotEmpty($team->getRememberToken());
        $this->assertNotEmpty($team->getRememberTokenName());
        $this->assertEquals('test@test.com', $team->getReminderEmail());

    }

}