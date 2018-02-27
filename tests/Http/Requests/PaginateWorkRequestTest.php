<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Http\Requests\PaginateWorkRequests;
use Belt\Core\Services\WorkRequestService;
use Illuminate\Database\Eloquent\Builder;

class PaginateWorkRequestTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Requests\PaginateWorkRequests::modifyQuery
     */
    public function test()
    {
        # modifyQuery
        $qbMock = m::mock(Builder::class);
        $qbMock->shouldReceive('where')->once()->with('work_requests.is_open', true);
        $qbMock->shouldReceive('where')->once()->with('work_requests.workflow_key', 'foo');
        $qbMock->shouldReceive('where')->once()->with('work_requests.workable_id', 123);
        $qbMock->shouldReceive('where')->once()->with('work_requests.workable_type', 'foo');
        $paginateRequest = new PaginateWorkRequests([
            'is_open' => true,
            'workflow_key' => 'foo',
            'workable_id' => 123,
            'workable_type' => 'foo',
        ]);
        $paginateRequest->modifyQuery($qbMock);
    }

}