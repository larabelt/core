<?php namespace Tests\Belt\Core\Unit\Behaviors;

use Belt;
use Belt\Core\Ability;
use Belt\Core\Behaviors\Permissible;
use Tests\Belt\Core;
use Illuminate\Database\Eloquent\Builder;
use Mockery as m;

class PermissibleTest extends \Tests\Belt\Core\BeltTestCase
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

class PermissibleStub //extends \Tests\Belt\Core\Base\BaseModelStub
{
    use Permissible;

    public $is_super = false;

}