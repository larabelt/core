<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Http\Requests\PaginateParams;
use Illuminate\Database\Eloquent\Builder;

class PaginateParamsTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Requests\PaginateParams::modifyQuery
     */
    public function test()
    {
        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('where')->once()->with('paramable_id', 1);
        $qbMock->shouldReceive('where')->once()->with('paramable_type', 'users');

        $paginateRequest = new PaginateParams(['paramable_id' => 1, 'paramable_type' => 'users']);

        # modifyQuery
        $paginateRequest->modifyQuery($qbMock);
    }

}