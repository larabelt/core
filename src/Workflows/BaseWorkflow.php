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
    protected static $events = [];

    /**
     * @var array
     */
    protected static $places = [];

    /**
     * @var string
     */
    protected static $initialPlace = 'start';

    /**
     * @var array
     */
    protected static $transitions = [];

    /**
     * @var array
     */
    protected static $closers = [];

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
    public static function key()
    {
        return static::KEY;
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
     * @return array|mixed
     */
    public static function events()
    {
        return static::$events;
    }

    /**
     * @return string
     */
    public static function initialPlace()
    {
        return static::$initialPlace;
    }

    /**
     * @return array|mixed
     */
    public static function places()
    {
        return static::$places;
    }

    /**
     * @return array|mixed
     */
    public static function transitions()
    {
        return static::$transitions;
    }

    /**
     * @return array
     */
    public static function closers()
    {
        return static::$closers;
    }

    /**
     * @return bool
     */
    public function shouldStart($params = [])
    {
        return true;
    }

    public function start($params = [])
    {

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
     * @return array
     */
    public function toArray()
    {
        return [
            'key' => static::KEY,
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