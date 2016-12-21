<?php
use Mockery as m;
use Ohio\Core\Base\Testing;

use Ohio\Core\TeamUser\TeamUser;
use Ohio\Core\TeamUser\Http\Requests\PaginateRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class PaginateRequestTest extends Testing\OhioTestCase
{

    use Testing\TestPaginateTrait;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Core\TeamUser\Http\Requests\PaginateRequest::modifyQuery
     * @covers \Ohio\Core\TeamUser\Http\Requests\PaginateRequest::teamUser
     * @covers \Ohio\Core\TeamUser\Http\Requests\PaginateRequest::items
     * @covers \Ohio\Core\TeamUser\Http\Requests\PaginateRequest::item
     */
    public function test()
    {
        $teamUser1 = new TeamUser();
        $teamUser1->id = 1;
        $teamUser1->team_id = 1;
        $teamUser1->user_id = 1;

        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('join')->once()->with('users', 'users.id', '=', 'team_users.user_id');
        $qbMock->shouldReceive('where')->once()->with('team_id', 1);
        $qbMock->shouldReceive('where')->once()->with('user_id', 1);
        $qbMock->shouldReceive('get')->once()->with(['team_users.id'])->andReturn(new Collection([$teamUser1]));
        $qbMock->shouldReceive('find')->times(2)->with(1)->andReturn($teamUser1);

        # modifyQuery
        $paginateRequest = new PaginateRequest(['team_id' => 1, 'user_id' => 1]);
        $paginateRequest->modifyQuery($qbMock);

        # teamUser
        $this->assertNull($paginateRequest->teamUser);
        $paginateRequest->teamUser();
        $this->assertInstanceOf(TeamUser::class, $paginateRequest->teamUser);

        # item
        $teamUserMock = m::mock(TeamUser::class);
        $teamUserMock->shouldReceive('with')->with('user')->andReturn($qbMock);
        $paginateRequest->teamUser = $teamUserMock;
        $this->assertEquals($teamUser1, $paginateRequest->item(1));

        # items
        $paginateRequest->items($qbMock);
    }

}