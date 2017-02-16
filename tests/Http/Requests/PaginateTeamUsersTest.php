<?php
use Mockery as m;
use Belt\Core\Testing;

use Belt\Core\User;
use Belt\Core\Http\Requests\PaginateTeamUsers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class PaginateTeamUsersTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Requests\PaginateTeamUsers::modifyQuery
     * @covers \Belt\Core\Http\Requests\PaginateTeamUsers::userRepo
     * @covers \Belt\Core\Http\Requests\PaginateTeamUsers::items
     * @covers \Belt\Core\Http\Requests\PaginateTeamUsers::item
     */
    public function test()
    {
        $user1 = new User();
        $user1->id = 1;
        $user1->email = 'test@test.com';

        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('join')->once()->with('team_users', 'team_users.user_id', '=', 'users.id');
        $qbMock->shouldReceive('where')->once()->with('team_users.team_id', 1);
        $qbMock->shouldReceive('get')->once()->with(['users.id'])->andReturn(new Collection([$user1]));
        $qbMock->shouldReceive('find')->times(2)->with(1)->andReturn($user1);
        $qbMock->shouldReceive('leftJoin')->once()->with('team_users',
            m::on(function (\Closure $closure) {
                $subQBMock = m::mock(Builder::class);
                $subQBMock->shouldReceive('on')->once()->with('team_users.user_id', '=', 'users.id');
                $subQBMock->shouldReceive('where')->once()->with('team_users.team_id', 1);
                $closure($subQBMock);
                return is_callable($closure);
            })
        );
        $qbMock->shouldReceive('whereNull')->once()->with('team_users.id');

        $paginateRequest = new PaginateTeamUsers(['user_id' => 1, 'team_id' => 1]);

        # userRepo
        $this->assertNull($paginateRequest->userRepo);
        $paginateRequest->userRepo();
        $this->assertInstanceOf(User::class, $paginateRequest->userRepo);

        # item
        $paginateRequest->userRepo = $qbMock;
        $this->assertEquals($user1, $paginateRequest->item(1));

        # items
        $paginateRequest->items($qbMock);

        # modifyQuery
        $paginateRequest->modifyQuery($qbMock);
        $paginateRequest->merge(['not' => true]);
        $paginateRequest->modifyQuery($qbMock);
    }

}