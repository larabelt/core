<?php

use Belt\Core\Testing;
use Belt\Core\Workflows\BaseWorkflow;
use Belt\Core\Services\WorkflowService;

class WorkRequestsFunctionalTest extends Testing\BeltTestCase
{

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        WorkflowService::push(WorkRequestsFunctionalStub::class);

        # index
        $response = $this->json('GET', '/api/v1/work-requests');
        $response->assertStatus(200);

        # store
        $response = $this->json('POST', '/api/v1/work-requests', [
            'workflow_key' => 'work-requests-functional-stub',
            'workable_id' => 1,
            'workable_type' => 'teams',
        ]);
        $response->assertStatus(201);
        $response->assertJsonFragment(['id']);
        $workRequestID = array_get($response->json(), 'id');

        # show
        $response = $this->json('GET', "/api/v1/work-requests/$workRequestID");
        $response->assertStatus(200);

        # update
        $this->json('PUT', "/api/v1/work-requests/$workRequestID", [
            'transition' => 'publish',
        ]);
        //$response = $this->json('GET', "/api/v1/work-requests/$workRequestID");
        //$response->assertJson(['place' => 'published']);

        # update (reset)
        $this->json('PUT', "/api/v1/work-requests/$workRequestID", [
            'reset' => true,
        ]);
        $response = $this->json('GET', "/api/v1/work-requests/$workRequestID");
        $response->assertJson(['place' => 'review']);

        # delete
        $response = $this->json('DELETE', "/api/v1/work-requests/$workRequestID");
        $response->assertStatus(204);
        $response = $this->json('GET', "/api/v1/work-requests/$workRequestID");
        $response->assertStatus(404);
    }

}

class WorkRequestsFunctionalStub extends BaseWorkflow
{
    const NAME = 'WorkRequestsFunctionalStub';

    const KEY = 'work-requests-functional-stub';

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