<?php

use Belt\Core\Testing;
use Belt\Core\Services\WorkflowService;
use Belt\Core\Services\WorkflowServiceTrait;

class WorkflowServiceTraitTest extends Testing\BeltTestCase
{
    /**
     * @covers \Belt\Core\Services\WorkflowServiceTrait::workflowService
     */
    public function test()
    {
        $stub = new WorkflowServiceTraitStub();
        $this->assertInstanceOf(WorkflowService::class, $stub->workflowService());
    }

}

class WorkflowServiceTraitStub
{
    use WorkflowServiceTrait;
}