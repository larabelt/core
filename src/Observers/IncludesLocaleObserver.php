<?php

namespace Belt\Core\Observers;

use Belt\Core\Behaviors\IncludesLocaleInterface;

class IncludesLocaleObserver
{
    /**
     * Listen to the IncludesLocaleInterface saving $item.
     *
     * @param  IncludesLocaleInterface $item
     * @return void
     */
    public function saving(IncludesLocaleInterface $item)
    {
        $item->locale = $item->locale ?: config('app.fallback_locale');
    }

}