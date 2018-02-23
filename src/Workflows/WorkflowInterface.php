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

    const KEY = null;

    const NAME = null;

    /**
     * BaseWorkflow constructor.
     * @param Model $workable
     */
    public function __construct(Model $workable = null);

    /**
     * Get the registered name of the workflow.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public static function key();

    /**
     * @return string
     */
    public static function initialPlace();

    /**
     * @return array|mixed
     */
    public static function places();

    /**
     * @return array|mixed
     */
    public static function transitions();

    /**
     * @return array
     */
    public static function closers();

    /**
     * @param array $params
     * @return bool
     */
    public function shouldStart($params = []);

    /**
     * @param array $params
     */
    public function start($params = []);

    /**
     * @param Model $workable
     */
    public function setWorkable(Model $workable);

    /**
     * @return Model $workable
     */
    public function getWorkable();

    /**
     * @return array
     */
    public function toArray();

}