<?php namespace Belt\Core\Behaviors;

use Belt\Core\Translation;
use Belt\Core\Observers\TranslatableObserver;

/**
 * Class Translatable
 * @package Belt\Core\Behaviors
 */
trait Translatable
{

    /**
     * Binds events to subclass
     */
    public static function bootTranslatable()
    {
        static::observe(TranslatableObserver::class);
    }

    /**
     * @return mixed
     */
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    /**
     * @param $key
     * @param $value
     * @param $locale
     * @return mixed
     */
    public function saveTranslation($key, $value, $locale = 'en_US')
    {
        $this->load('translations');
        $translation = $this->translations()->firstOrNew([
            'locale' => $locale,
            'key' => $key,
        ]);
        $translation->value = $value;
        $translation->save();

        return $translation;
    }

    /**
     * @param $key
     * @param null $default
     * @return null
     */
    public function translation($key, $default = null)
    {
        $translation = $this->translations->where('key', $key)->first();

        return $translation ? $translation->value : $default;
    }

}