<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\WorkRequest;
use Belt\Core\Http\Requests\UpdateWorkRequest;
use Belt\Core\Services\WorkflowService;
use Illuminate\Database\Eloquent\Builder;

class UpdateWorkRequestTest extends Testing\BeltTestCase
{

    use Testing\CommonMocks;

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Requests\UpdateWorkRequest::service
     * @covers \Belt\Core\Http\Requests\UpdateWorkRequest::rules
     */
    public function test()
    {
        $request = new UpdateWorkRequest([
            'transition' => 'foo',
            'place' => 'foo',
        ]);

        $workRequest = factory(WorkRequest::class)->make();

        $request = m::mock(UpdateWorkRequest::class . '[get,route]');
        $request->shouldReceive('get')->with('transition')->andReturn('foo');
        $request->shouldReceive('get')->with('place')->andReturn('foo');
        $request->shouldReceive('route')->with('workRequest')->andReturn($workRequest);

        # service
        $this->assertInstanceOf(WorkflowService::class, $request->service());

        # rules
        $this->assertNotEmpty($request->rules());
    }

}