<?php

namespace Belt\Core\Workflows;

use Belt, Illuminate;
use Illuminate\Database\Eloquent\Model;
use Belt\Core\WorkRequest;
use Symfony\Component\Workflow\DefinitionBuilder;
use Symfony\Component\Workflow\Transition;
use Symfony\Component\Workflow\Workflow;
use Symfony\Component\Workflow\MarkingStore\SingleStateMarkingStore;

/**
 * Class BaseWorkflow
 * @package Belt\Core\Workflows
 */
interface WorkflowInterface
{

    const NAME = null;

    public function __construct(Model $item);

    //public function create();

}