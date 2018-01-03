<?php

namespace Belt\Core\Services;

use Cache;
use Belt\Core\Alert;

/**
 * Class AlertService
 * @package Belt\Core\Services
 */
class AlertService
{

    /**
     * Setup cache if missing
     */
    public function init()
    {
        if (!Cache::has('alerts')) {
            $this->cache();
        }
    }

    /**
     * Save alerts to cache
     */
    public function cache()
    {
        $alerts = Alert::active()->get();

        $alerts = $alerts->keyBy('id');

        Cache::put('alerts', $alerts, 3600);
    }

}