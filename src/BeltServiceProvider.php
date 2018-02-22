<?php

namespace Belt\Core;

use Belt, Event, Morph;
use Belt\Core\Services\WorkflowService;
use Belt\Core\Observers\WorkflowObserver;
use Illuminate\Support\ServiceProvider;

/**
 * Class BeltCoreServiceProvider
 * @package Belt\Core
 */
class BeltServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $workflows = [];

    /**
     * Register workflows
     */
    protected function workflows()
    {
        foreach ($this->workflows as $eventName => $workflowClasses) {
            foreach ((array) $workflowClasses as $workflowClass) {
                WorkflowService::registerWorkflow($workflowClass);
                Event::listen($eventName, function ($event, $payload = []) use ($workflowClass) {
                    $service = new WorkflowService();
                    $service->handle(new $workflowClass(), $event->item(), $event->user(), $payload);
                });
            }
        }
    }

}