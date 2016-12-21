<?php

use Ohio\Core\Base\Testing\OhioTestCase;
use Ohio\Core\Team\Team;
use Ohio\Core\User\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TeamTest extends OhioTestCase
{
    /**
     * @covers \Ohio\Core\Team\Team::__toString
     * @covers \Ohio\Core\Team\Team::setIsActiveAttribute
     * @covers \Ohio\Core\Team\Team::setNameAttribute
     * @covers \Ohio\Core\Team\Team::users
     */
    public function test()
    {
        $team = factory(Team::class)->make();
        $user = factory(User::class)->make(['email' => 'test@test.com']);

        Team::unguard();

        $team->is_active = 1;
        $team->name = ' TEST ';

        $attributes = $team->getAttributes();

        # users relationship
        $this->assertInstanceOf(BelongsToMany::class, $team->users());
        $team->users->add(factory(User::class)->make(['email' => 'test@test.com']));
        $this->assertEquals(1, $team->users->count());

        # setters
        $this->assertEquals('TEST', $team->__toString());
        $this->assertEquals(true, $attributes['is_active']);
        $this->assertEquals('TEST', $attributes['name']);


    }

}