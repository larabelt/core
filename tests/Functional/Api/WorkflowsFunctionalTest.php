<?php

use Belt\Core\Testing;
use Belt\Core\Workflows\BaseWorkflow;
use Belt\Core\Services\WorkflowService;

class WorkflowsFunctionalTest extends Testing\BeltTestCase
{

    public function test()
    {
        $this->actAsSuper();

        WorkflowService::push(WorkflowsFunctionalStub::class);

        $response = $this->json('GET', '/api/v1/workflows');
        $response->assertStatus(200);

        $this->assertNotNull(array_get($response->json(), WorkflowsFunctionalStub::KEY));
    }

}

class WorkflowsFunctionalStub extends BaseWorkflow
{
    const NAME = 'WorkflowsFunctionalStub';

    const KEY = 'workflows-functional-stub';

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

}