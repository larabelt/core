<?php

use Mockery as m;
use Ohio\Core\Base\Testing;

use Ohio\Core\TeamUser\TeamUser;
use Ohio\Core\TeamUser\Http\Requests\PaginateRequest;
use Ohio\Core\Base\Pagination\BaseLengthAwarePaginator;

class PaginateRequestTest extends Testing\OhioTestCase
{

    use Testing\TestPaginateTrait;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Core\TeamUser\Http\Requests\PaginateRequest::modifyQuery
     */
    public function test()
    {
        $teamUser1 = new TeamUser();
        $teamUser1->user_id = 1;

        # modifyQuery
        $qbMock = $this->getPaginateQBMock(new PaginateRequest(), [$teamUser1]);
        $qbMock->shouldReceive('where')->once()->withArgs(['team_id', 1]);
        $qbMock->shouldReceive('where')->once()->withArgs(['user_id', 2]);
        new BaseLengthAwarePaginator($qbMock, new PaginateRequest(['team_id' => 1, 'user_id' => 2]));
    }

}