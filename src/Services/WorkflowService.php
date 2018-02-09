<?php

namespace Belt\Core\Services;

use Belt;
use Belt\Core\Workflows\WorkflowInterface;
use Illuminate\Database\Eloquent\Model;

class WorkflowService
{
    use Belt\Core\Behaviors\CanEnable;
    /**
     * @var array
     */
    public static $workflows = [];

    /**
     * @param $type
     * @param $workflow
     */
    public static function push($type, $workflow)
    {
        static::$workflows[$type][] = $workflow;
    }

    /**
     * @param $item
     * @return mixed
     */
    public static function workflows($item)
    {
        return array_get(static::$workflows, $item->getMorphClass(), []);
    }

    public function saved($item, $class)
    {
        $workflow = new $class($item);
        $workflow->saved();
    }

}