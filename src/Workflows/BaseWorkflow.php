<?php

namespace Belt\Core\Workflows;

use Belt, Illuminate;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseWorkflow
 * @package Belt\Core\Workflows
 */
class BaseWorkflow implements Belt\Core\Workflows\WorkflowInterface
{
    /**
     * @var array
     */
    protected $places = [];

    /**
     * @var string
     */
    protected $initialPlace = 'start';

    /**
     * @var array
     */
    protected $transitions = [];

    /**
     * @var array
     */
    protected $closers = [];

    /**
     * @var Model
     */
    protected $workable;

    /**
     * Get the registered name of the workflow.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public static function getAccessor()
    {
        return static::ACCESSOR;
    }

    /**
     * BaseWorkflow constructor.
     * @param Model $workable
     */
    public function __construct(Model $workable = null)
    {
        if ($workable) {
            $this->setWorkable($workable);
        }
    }

    /**
     * @return bool
     */
    public function isApplicable()
    {
        return true;
    }

    /**
     * @param Model $workable
     */
    public function setWorkable(Model $workable)
    {
        $this->workable = $workable;
    }

    /**
     * @return Model $workable
     */
    public function getWorkable()
    {
        return $this->workable;
    }

    /**
     * @return string
     */
    public function initialPlace()
    {
        return $this->initialPlace;
    }

    /**
     * @return array|mixed
     */
    public function places()
    {
        return $this->places;
    }

    /**
     * @return array|mixed
     */
    public function transitions()
    {
        return $this->transitions;
    }

    /**
     * @return array
     */
    public function closers()
    {
        return $this->closers;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'accessor' => static::ACCESSOR,
            'name' => static::NAME,
            'initialPlace' => $this->initialPlace(),
            'places' => $this->places(),
            'transitions' => $this->transitions(),
            'workable' => [
                'label' => '',
                'editUrl' => '',
            ],
        ];
    }

}