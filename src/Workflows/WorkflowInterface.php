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

    const ACCESSOR = null;

    const NAME = null;

    /**
     * Get the registered name of the workflow.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public static function getAccessor();

    /**
     * BaseWorkflow constructor.
     * @param Model $workable
     */
    public function __construct(Model $workable = null);

    /**
     * @return bool
     */
    public function begin($workable = null, $payload = []);

    /**
     * @param Model $workable
     */
    public function setWorkable(Model $workable);

    /**
     * @return Model $workable
     */
    public function getWorkable();

    /**
     * @return string
     */
    public function initialPlace();

    /**
     * @return array|mixed
     */
    public function places();

    /**
     * @return array|mixed
     */
    public function transitions();

    /**
     * @return array
     */
    public function closers();

    /**
     * @return array
     */
    public function toArray();

}