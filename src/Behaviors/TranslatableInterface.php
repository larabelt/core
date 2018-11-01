<?php namespace Belt\Core\Behaviors;

/**
 * Interface TranslatableInterface
 * @package Belt\Core\Behaviors
 */
interface TranslatableInterface
{

    /**
     * Binds events to subclass
     */
    public static function bootTranslatable();

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function translations();

    /**
     * @return mixed
     */
    public function getTranslatableAttributes();

    /**
     * @return mixed
     */
    public function getTranslatedAttributes();

    /**
     * @param $attribute
     * @param $value
     * @param $locale
     * @return mixed
     */
    public function saveTranslation($attribute, $value, $locale);

    /**
     * @param string $locale
     */
    public function translate($locale);

    public function untranslate();

}