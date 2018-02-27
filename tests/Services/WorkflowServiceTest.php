<?php

use Mockery as m;
use Belt\Core\Team;
use Belt\Core\Testing;
use Belt\Core\Services\WorkflowService;
use Belt\Core\Workflows\BaseWorkflow;
use Belt\Core\Facades\MorphFacade as Morph;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\Workflow\Workflow as Helper;

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
     * @covers \Belt\Core\Services\WorkflowService::helper
     * @covers \Belt\Core\Services\WorkflowService::availableTransitions
     */
    public function test()
    {
        $service = new WorkflowService();
        $workflow = new WorkflowServiceStub();
        $team = factory(Team::class)->make();

        # push / get
        WorkflowService::push(WorkflowServiceStub::class);
        $this->assertNotEmpty(array_get(WorkflowService::get(), 'workflow-service-stub'));
        $this->assertNotEmpty(WorkflowService::get('workflow-service-stub'));

        # helper
        //$this->assertInstanceOf(Helper::class, $service->helper($workflow));

        # handle
        $qb = m::mock(Builder::class);
        Morph::shouldReceive('type2QB')->with('work_requests')->andReturn($qb);
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

    public function shouldStart($params = [])
    {
        parent::shouldStart($params);
        return false;
    }

    public function start($params = [])
    {
        parent::start($params);
        $team = array_get($params, 'workable');
        $team->is_active = false;
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['foo'] = 'bar';

        return $array;
    }

}