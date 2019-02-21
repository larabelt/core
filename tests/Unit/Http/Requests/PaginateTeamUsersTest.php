<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Requests\PaginateTeamUsers;
use Belt\Core\Tests;
use Illuminate\Database\Eloquent\Builder;
use Mockery as m;

class PaginateTeamUsersTest extends Tests\BeltTestCase
{

    use Tests\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Requests\PaginateTeamUsers::modifyQuery
     * @covers \Belt\Core\Http\Requests\PaginateTeamUsers::items
     */
    public function test()
    {
        # modifyQuery (not === false)
        $qb1 = m::mock(Builder::class);
        $qb1->shouldReceive('join')->once()->with('team_users', 'team_users.user_id', '=', 'users.id');
        $qb1->shouldReceive('where')->once()->with('team_users.team_id', 1);
        $request = new PaginateTeamUsers(['team_id' => 1]);
        $request->modifyQuery($qb1);
        $this->assertNotEmpty($request->joins['team_users']);
        foreach ($request->joins as $join) {
            $join($qb1, $request);
        }

        # modifyQuery (not === true)
        $qb2 = m::mock(Builder::class);
        $qb2->shouldReceive('leftJoin')->once()->with('team_users',
            m::on(function (\Closure $closure) {
                $sub = m::mock(Builder::class);
                $sub->shouldReceive('on')->once()->with('team_users.user_id', '=', 'users.id');
                $sub->shouldReceive('where')->once()->with('team_users.team_id', 1);
                $closure($sub);
                return is_callable($closure);
            })
        );
        $qb2->shouldReceive('whereNull')->once()->with('team_users.id');
        $request = new PaginateTeamUsers(['team_id' => 1, 'not' => true]);
        $request->modifyQuery($qb2);
        $this->assertNotEmpty($request->joins['team_users']);
        foreach ($request->joins as $join) {
            $join($qb2, $request);
        }
    }

}