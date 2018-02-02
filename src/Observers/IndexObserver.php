<?php

namespace Belt\Core\Observers;

use Belt;
use Belt\Core\Services\IndexService;
use Illuminate\Database\Eloquent\Model;

class IndexObserver
{
    /**
     * Listen to the Model saved $item.
     *
     * @param Model $item
     */
    public function saved(Model $item)
    {
        if (IndexService::isEnabled()) {
            dispatch(new Belt\Core\Jobs\UpdateIndexRecord($item));
        }
    }

    /**
     * Listen to the Model saved $item.
     *
     * @param Model $item
     */
    public function deleted(Model $item)
    {
        if (IndexService::isEnabled()) {
            dispatch(new Belt\Core\Jobs\UpdateIndexRecord($item));
        }
    }
}