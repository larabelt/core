<?php

namespace Belt\Core\Observers;

use Translate;
use Belt\Core\Behaviors\TranslatableInterface;

class TranslatableObserver
{
    /**
     * Listen to the Model saving $item.
     *
     * @param TranslatableInterface $item
     */
    public function saving(TranslatableInterface $item)
    {
//        if ($locale = Translate::getAlternateLocale()) {
//            if ($translatable = $item->getTranslatable()) {
//                foreach ($item->getDirty() as $attribute => $newValue) {
//                    $oldValue = $item->getOriginal($attribute);
//                    //dump("$attribute: $oldValue --> $newValue");
//                    $item->setAttribute($attribute, $oldValue ?: $newValue);
//                    if (in_array($attribute, (array) $translatable)) {
//                        $item->saveTranslation($attribute, $newValue, $locale);
//                    }
//                }
//            }
//        }
    }

    /**
     * Listen to the Model saving $item.
     *
     * @param TranslatableInterface $item
     */
    public function saved(TranslatableInterface $item)
    {
        if ($locale = Translate::getAlternateLocale()) {
            //$item->setTranslations($locale);
        }
    }

    /**
     * Listen to the TranslatableInterface retrieved $item.
     *
     * @param  TranslatableInterface $item
     * @return void
     */
    public function retrieved(TranslatableInterface $item)
    {
        if ($locale = Translate::getAlternateLocale() && Translate::canTranslateObjects()) {
            $item->setTranslations($locale);
        }
    }

}