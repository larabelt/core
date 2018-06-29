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
            foreach ($item->translations->where('locale', $locale) as $translation) {
                $item->setAttribute($translation->key, $translation->value);
            }
        }
    }
}