<?php namespace Belt\Core\Behaviors;

use Belt\Core\Translation;

/**
 * Interface TranslatableInterface
 * @package Belt\Core\Behaviors
 */
interface TranslatableInterface
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function translations();

    /**
     * @param $attribute
     * @param $value
     * @param $locale
     * @return mixed
     */
    public function saveTranslation($attribute, $value, $locale = 'en_US');

    /**
     * @param string $locale
     */
    public function setTranslations($locale = 'en_US');

}