<?php

use Mockery as m;
use Ohio\Core\Base\Testing;

use Ohio\Core\UserRole\UserRole;
use Ohio\Core\UserRole\Http\Requests\PaginateRequest;
use Ohio\Core\Base\Pagination\BaseLengthAwarePaginator;

class PaginateRequestTest extends Testing\OhioTestCase
{

    use Testing\TestPaginateTrait;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Core\UserRole\Http\Requests\PaginateRequest::modifyQuery
     */
    public function test()
    {
        $userRole1 = new UserRole();
        $userRole1->role_id = 1;

        # modifyQuery
        $qbMock = $this->getPaginateQBMock(new PaginateRequest(), [$userRole1]);
        $qbMock->shouldReceive('where')->once()->withArgs(['user_id', 1]);
        $qbMock->shouldReceive('where')->once()->withArgs(['role_id', 2]);
        new BaseLengthAwarePaginator($qbMock, new PaginateRequest(['user_id' => 1, 'role_id' => 2]));
    }

}