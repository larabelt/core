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
     */
    public function test()
    {
        # modifyQuery (not === false)
        $qb1 = m::mock(Builder::class);
        $qb1->shouldReceive('join')->once()->with('user_roles', 'user_roles.role_id', '=', 'roles.id');
        $qb1->shouldReceive('where')->once()->with('user_roles.user_id', 1);
        $request = new PaginateUserRoles(['role_id' => 1, 'user_id' => 1]);
        $request->modifyQuery($qb1);
        $this->assertNotEmpty($request->joins['user_roles']);
        foreach ($request->joins as $join) {
            $join($qb1, $request);
        }

        # modifyQuery (not === true)
        $qb2 = m::mock(Builder::class);
        $qb2->shouldReceive('leftJoin')->once()->with('user_roles',
            m::on(function (\Closure $closure) {
                $subQBMock = m::mock(Builder::class);
                $subQBMock->shouldReceive('on')->once()->with('user_roles.role_id', '=', 'roles.id');
                $subQBMock->shouldReceive('where')->once()->with('user_roles.user_id', 1);
                $closure($subQBMock);
                return is_callable($closure);
            })
        );
        $qb2->shouldReceive('whereNull')->once()->with('user_roles.id');
        $request = new PaginateUserRoles(['role_id' => 1, 'user_id' => 1, 'not' => true]);
        $request->modifyQuery($qb2);
        $this->assertNotEmpty($request->joins['user_roles']);
        foreach ($request->joins as $join) {
            $join($qb2, $request);
        }
    }

}