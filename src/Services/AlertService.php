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
     * @return null
     */
    public function cache()
    {
        $alerts = Alert::active()->get();

        $alerts = $alerts->keyBy('id');

        Cache::put('alerts', $alerts, 3600);
    }

}