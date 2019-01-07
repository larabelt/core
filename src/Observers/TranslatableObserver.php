<?php

namespace Belt\Core\Observers;

use Translate;
use Belt\Core\Behaviors\TranslatableInterface;

class TranslatableObserver
{
    /**
     * Listen to the TranslatableInterface retrieved $item.
     *
     * @param  TranslatableInterface $item
     * @return void
     */
    public function retrieved(TranslatableInterface $item)
    {
        if ($locale = Translate::getAlternateLocale()) {
            if (Translate::canTranslateObjects()) {
                $item->translate($locale);
            }
        }
    }

    /**
     * Listen to the Model saving $item.
     *
     * @param TranslatableInterface $item
     */
    public function saving(TranslatableInterface $item)
    {
        $item->untranslate();
    }

    /**
     * Listen to the Model saving $item.
     *
     * @param TranslatableInterface $item
     */
    public function saved(TranslatableInterface $item)
    {
        $item->retranslate();
    }

}