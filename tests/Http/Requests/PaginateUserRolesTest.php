<?php
use Mockery as m;
use Belt\Core\Testing;

use Belt\Core\Role;
use Belt\Core\Http\Requests\PaginateUserRoles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class PaginateUserRolesTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Requests\PaginateUserRoles::modifyQuery
     * @covers \Belt\Core\Http\Requests\PaginateUserRoles::roles
     */
    public function test()
    {
        Role::unguard();

        $role1 = new Role();
        $role1->id = 1;
        $role1->name = 'test';

        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('select')->twice()->with(['roles.*']);
        $qbMock->shouldReceive('join')->once()->with('user_roles', 'user_roles.role_id', '=', 'roles.id');
        $qbMock->shouldReceive('where')->once()->with('user_roles.user_id', 1);
        $qbMock->shouldReceive('leftJoin')->once()->with('user_roles',
            m::on(function (\Closure $closure) {
                $subQBMock = m::mock(Builder::class);
                $subQBMock->shouldReceive('on')->once()->with('user_roles.role_id', '=', 'roles.id');
                $subQBMock->shouldReceive('where')->once()->with('user_roles.user_id', 1);
                $closure($subQBMock);
                return is_callable($closure);
            })
        );
        $qbMock->shouldReceive('whereNull')->once()->with('user_roles.id');

        $paginateRequest = new PaginateUserRoles(['role_id' => 1, 'user_id' => 1]);

        # roles
        $this->assertNull($paginateRequest->roleRepo);
        $paginateRequest->roles();
        $this->assertInstanceOf(Role::class, $paginateRequest->roles);

        # modifyQuery
        $paginateRequest->modifyQuery($qbMock);
        $paginateRequest->merge(['not' => true]);
        $paginateRequest->modifyQuery($qbMock);
    }

}