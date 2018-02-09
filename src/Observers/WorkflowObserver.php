<?php

namespace Belt\Core\Observers;

use Belt;
use Belt\Core\Services\WorkflowService;
use Illuminate\Database\Eloquent\Model;

class WorkflowObserver
{

    /**
     * @var WorkflowService
     */
    public $service;

    /**
     * @return WorkflowService
     */
    public function service()
    {
        return $this->service ?: $this->service = new WorkflowService();
    }

    /**
     * Listen to the saving $item.
     *
     * @param  Model $item
     * @return void
     */
    public function created(Model $item)
    {
        foreach ($this->service()->workflows($item) as $class) {

        }
    }

    /**
     * Listen to the saving $item.
     *
     * @param  Model $item
     * @return void
     */
    public function saved(Model $item)
    {
        foreach ($this->service()->workflows($item) as $class) {
            $this->service()->saved($item, $class);
        }
    }
}