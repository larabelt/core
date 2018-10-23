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
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    /**
     * @return mixed
     */
    public function getTranslatable()
    {
        return $this->config('translatable');
    }

    /**
     * @param $attribute
     * @param $value
     * @param $locale
     * @return mixed
     */
    public function saveTranslation($attribute, $value, $locale = 'en_US')
    {
        $translation = $this->translations()->updateOrCreate([
            'locale' => $locale,
            'translatable_column' => $attribute,
        ], [
            'value' => $value
        ]);

        return $translation;
    }

    /**
     * @param string $locale
     */
    public function setTranslations($locale = 'en_US')
    {
        $this->load('translations');
        foreach ($this->translations->where('locale', $locale) as $translation) {
            $this->setAttribute($translation->translatable_column, $translation->value);
        }
    }

}