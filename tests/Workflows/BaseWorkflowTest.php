<?php

use Mockery as m;
use Belt\Core\Testing\BeltTestCase;
use Belt\Core\WorkRequest;
use Belt\Core\Workflows\BaseWorkflow;
use Belt\Core\Services\WorkflowService;

class BaseWorkflowTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Workflows\BaseWorkflow::__construct
     * @covers \Belt\Core\Workflows\BaseWorkflow::events
     * @covers \Belt\Core\Workflows\BaseWorkflow::initialPlace
     * @covers \Belt\Core\Workflows\BaseWorkflow::places
     * @covers \Belt\Core\Workflows\BaseWorkflow::transitions
     * @covers \Belt\Core\Workflows\BaseWorkflow::closers
     * @covers \Belt\Core\Workflows\BaseWorkflow::shouldStart
     * @covers \Belt\Core\Workflows\BaseWorkflow::start
     * @covers \Belt\Core\Workflows\BaseWorkflow::setWorkable
     * @covers \Belt\Core\Workflows\BaseWorkflow::getWorkable
     * @covers \Belt\Core\Workflows\BaseWorkflow::toArray
     */
    public function test()
    {
        $workable = factory(\Belt\Core\Team::class)->make();

        WorkflowService::push(BaseWorkflowStub::class);

        $workflow = new BaseWorkflowStub($workable);

        # construct / workable
        $this->assertEquals($workable, $workflow->getWorkable());

        # events / places / clostransitionsers / closers
        $this->assertNotEmpty($workflow->events());
        $this->assertNotEmpty($workflow->places());
        $this->assertNotEmpty($workflow->transitions());
        $this->assertNotEmpty($workflow->closers());

        # initialPlace
        $this->assertEquals('review', $workflow->initialPlace());

        # shouldStart
        $this->assertFalse($workflow->shouldStart());

        # start
        $workable->is_active = true;
        $workflow->start(['workable' => $workable]);
        $this->assertFalse($workable->is_active);

        # toArray
        $this->assertEquals('bar', array_get($workflow->toArray(), 'foo'));

    }

}

class BaseWorkflowStub extends BaseWorkflow
{
    const NAME = 'BaseWorkflowStub';

    const KEY = 'base-workflow-stub';

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