<?php

use Mockery as m;

use Ohio\Core\Base\Testing\OhioTestCase;
use Ohio\Core\UserRole\UserRole;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRoleTest extends OhioTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * covers \Ohio\Core\UserRole\UserRole::role
     * covers \Ohio\Core\UserRole\UserRole::user
     * covers \Ohio\Core\UserRole\UserRole::create
     */
    public function test()
    {

        $userRole = new UserRole();

        # role relationship
        $this->assertInstanceOf(BelongsTo::class, $userRole->role());

        # user relationship
        $this->assertInstanceOf(BelongsTo::class, $userRole->user());

        # create
        $userRole = m::mock(UserRole::class . '[firstOrCreate]');
        $userRole->shouldReceive('firstOrCreate')->once();
        $userRole->create();
    }

}