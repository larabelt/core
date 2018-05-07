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
        foreach ($this->workflows as $class) {
            WorkflowService::push($class);
            foreach ((array) $class::events() as $eventName) {
                Event::listen($eventName, function ($event, $payload = []) use ($class) {
                    $service = new WorkflowService();
                    $service->handle(new $class(), $event->item(), $event->user(), $payload);
                });
            }
        }
    }

}