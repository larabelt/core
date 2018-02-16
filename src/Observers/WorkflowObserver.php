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
     * Listen to the created $item.
     *
     * @param  Model $item
     * @return void
     */
    public function created(Model $item)
    {
        if (WorkflowService::isEnabled()) {
            foreach (WorkflowService::workflows($item) as $class) {
                //$this->service()->created($item, $class);
            }
        }
    }

    /**
     * Listen to the saving $item.
     *
     * @param  Model $item
     * @return void
     */
    public function updated(Model $item)
    {
        if (WorkflowService::isEnabled()) {
            foreach (WorkflowService::workflows($item) as $class) {
                //$this->service()->saved($item, $class);
            }
        }
    }

    /**
     * Listen to the created $item.
     *
     * @param  Model $item
     * @return void
     */
    public function deleted(Model $item)
    {
        if (WorkflowService::isEnabled()) {
            foreach (WorkflowService::workflows($item) as $class) {
                //$this->service()->deleted($item, $class);
            }
        }
    }
}