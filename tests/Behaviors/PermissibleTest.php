<?php

use Mockery as m;
use Belt\Core\Behaviors\Permissible;
use Belt\Core\Ability;
use Belt\Core\Testing;
use Belt\Core\Facades\MorphFacade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PermissibleTest extends Testing\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Behaviors\Permissible::can
     * @covers \Belt\Core\Behaviors\Permissible::setSuper
     * @covers \Belt\Core\Behaviors\Permissible::super
     * @covers \Belt\Core\Behaviors\Permissible::getSuperAttribute
     */
    public function test()
    {

        # setSuper, super, getSuperAttribute
        $abilitiesQB = m::mock(Builder::class);
        $abilitiesQB->shouldReceive('where')->once()->with('entity_type', '*')->andReturnSelf();
        $abilitiesQB->shouldReceive('where')->once()->with('name', '*')->andReturnSelf();
        $abilitiesQB->shouldReceive('first')->once()->andReturn(null);

        $permissible = m::mock(PermissibleStub::class . '[getAttribute, getAbilities]');
        $permissible->shouldReceive('getAttribute')->once()->with('is_super')->andReturn(false);
        $permissible->shouldReceive('getAbilities')->once()->andReturn($abilitiesQB);

        $this->assertNotTrue($permissible->getSuperAttribute());
        $permissible->setSuper(true);
        $this->assertTrue($permissible->getSuperAttribute());

        # super, continued
        $permissible = m::mock(PermissibleStub::class . '[getAttribute]');
        $permissible->shouldReceive('getAttribute')->once()->with('is_super')->andReturn(true);
        $this->assertTrue($permissible->getSuperAttribute());

        # super, continued
        $abilitiesQB = m::mock(Builder::class);
        $abilitiesQB->shouldReceive('where')->once()->with('entity_type', '*')->andReturnSelf();
        $abilitiesQB->shouldReceive('where')->once()->with('name', '*')->andReturnSelf();
        $abilitiesQB->shouldReceive('first')->once()->andReturn(new Ability());

        $permissible = m::mock(PermissibleStub::class . '[getAttribute, getAbilities]');
        $permissible->shouldReceive('getAttribute')->once()->with('is_super')->andReturn(false);
        $permissible->shouldReceive('getAbilities')->once()->andReturn($abilitiesQB);

        $this->assertTrue($permissible->getSuperAttribute());

        # can
        $permissible = m::mock(PermissibleStub::class . '[parentCan]');
        $permissible->shouldReceive('parentCan')->once()->with('attach', Belt\Core\Role::class)->andReturn(false);
        $permissible->shouldReceive('parentCan')->once()->with('view', Belt\Core\User::class)->andReturn(false);
        $this->assertFalse($permissible->can('attach', 'roles'));
        $this->assertFalse($permissible->can('view', 'users'));

    }

}

class PermissibleStub //extends Testing\BaseModelStub
{
    use Permissible;

    public $is_super = false;

}