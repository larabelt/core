<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermissionTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Permission::ability
     */
    public function test()
    {
        $permission = new Permission();

        # ability
        $this->assertInstanceOf(BelongsTo::class, $permission->ability());
    }

}