<?php

namespace Belt\Core;

use Belt, Morph;
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
        foreach ($this->workflows as $type => $workflows) {
            $workflows = is_array($workflows) ? $workflows : [$workflows];
            foreach ($workflows as $workflow) {
                WorkflowService::push($type, $workflow);
                $class = Morph::type2Class($type);
                $class::observe(WorkflowObserver::class);
            }
        }
    }

}