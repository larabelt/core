<?php

use Mockery as m;
use Ohio\Core\Base\Testing;

use Ohio\Core\UserRole\UserRole;
use Ohio\Core\UserRole\Http\Requests\PaginateUserRoles;
use Ohio\Core\Base\Pagination\BaseLengthAwarePaginator;

class PaginateUserRolesTest extends Testing\OhioTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Ohio\Core\UserRole\Http\Requests\PaginateUserRoles::modifyQuery
     */
    public function test()
    {
        $userRole1 = new UserRole();
        $userRole1->role_id = 1;

        # modifyQuery
        $qbMock = $this->getPaginateQBMock(new PaginateUserRoles(), [$userRole1]);
        $qbMock->shouldReceive('where')->once()->withArgs(['user_id', 1]);
        $qbMock->shouldReceive('where')->once()->withArgs(['role_id', 2]);
        new BaseLengthAwarePaginator($qbMock, new PaginateUserRoles(['user_id' => 1, 'role_id' => 2]));
    }

}