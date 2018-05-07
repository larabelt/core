<?php

use Mockery as m;
use Belt\Core\Team;
use Belt\Core\Testing;
use Belt\Core\WorkRequest;
use Belt\Core\Services\WorkflowService;
use Belt\Core\Workflows\BaseWorkflow;
use Belt\Core\Facades\MorphFacade as Morph;
use Illuminate\Database\Eloquent\Builder;

class WorkflowServiceTest extends Testing\BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Services\WorkflowService::push
     * @covers \Belt\Core\Services\WorkflowService::get
     * @covers \Belt\Core\Services\WorkflowService::handle
     * @covers \Belt\Core\Services\WorkflowService::createWorkRequest
     * @covers \Belt\Core\Services\WorkflowService::apply
     * @covers \Belt\Core\Services\WorkflowService::reset
     * @covers \Belt\Core\Services\WorkflowService::availableTransitions
     * @covers \Belt\Core\Services\WorkflowService::can
     */
    public function test()
    {
        $service = new WorkflowService();
        $workflow = new WorkflowServiceStub();

        Team::unguard();
        $team = factory(Team::class)->make(['id' => 123]);

        # push / get
        WorkflowService::push(WorkflowServiceStub::class);
        $this->assertNotEmpty(array_get(WorkflowService::get(), 'workflow-service-stub'));
        $this->assertNotEmpty(WorkflowService::get('workflow-service-stub'));

        # helper
        //$this->assertInstanceOf(Helper::class, $service->helper($workflow));

        # handle / createWorkRequest
        $workRequest = m::mock(WorkRequest::class);
        $workRequest->shouldReceive('update')->with([
            'place' => $workflow::initialPlace(),
            'payload' => [],
        ]);
        $qb = m::mock(Builder::class);
        $qb->shouldReceive('firstOrCreate')->with([
            'is_open' => true,
            'workable_id' => $team->id,
            'workable_type' => 'teams',
            'workflow_key' => $workflow::KEY,
        ])->andReturn($workRequest);
        Morph::shouldReceive('type2QB')->with('work_requests')->andReturn($qb);
        $service->handle($workflow, $team);

        # availableTransitions
        $this->assertEquals(['publish', 'reject'], $service->availableTransitions($workflow));

        # reset
        $workRequest = new WorkflowServiceWorkRequestStub();
        $workRequest->is_open = false;
        $workRequest->place = 'rejected';
        $service->reset($workRequest);
        $this->assertEquals(true, $workRequest->is_open);
        $this->assertEquals(null, $workRequest->place);

        # can
        $this->assertFalse($service->can($workflow, 'review', 'dodge'));
        $this->assertTrue($service->can($workflow, 'review', 'publish'));
        $this->assertTrue($service->can($workflow, 'review', 'reject'));

        # apply
        $workRequest = new WorkflowServiceWorkRequestStub();
        $workRequest->workable = $team;
        $workRequest->is_open = true;
        $workRequest->place = 'review';
        $workRequest->workflow_key = 'workflow-service-stub';
        $service->apply($workRequest, 'publish');
        $this->assertEquals(false, $workRequest->is_open);
        $this->assertEquals('published', $workRequest->place);
        $this->assertEquals('foo', $team->body);
    }

}

class WorkflowServiceStub extends BaseWorkflow
{
    const NAME = 'WorkflowServiceStub';

    const KEY = 'workflow-service-stub';

    protected static $events = [
        'teams.created',
    ];

    protected static $initialPlace = 'review';

    protected static $places = [
        'review',
        'rejected',
        'published'
    ];

    protected static $transitions = [
        'publish' => [
            'from' => 'review',
            'to' => 'published',
        ],
        'reject' => [
            'from' => 'review',
            'to' => 'rejected',
        ],
    ];

    protected static $closers = [
        'publish',
        'reject',
    ];

    public function applyPublish($params = [])
    {
        if ($team = array_get($params, 'workable')) {
            $team->body = 'foo';
        }
    }

}

class WorkflowServiceWorkRequestStub extends WorkRequest
{
    public function save(array $options = [])
    {

    }
}