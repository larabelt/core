<?php namespace Tests\Belt\Core\Unit;

use Belt\Core\Permission;
use Belt\Core\Tests\BeltTestCase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mockery as m;

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