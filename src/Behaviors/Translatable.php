<?php namespace Belt\Core\Behaviors;

use Belt\Core\Translation;
use Belt\Core\Observers\TranslatableObserver;

/**
 * Class Translatable
 * @package Belt\Core\Behaviors
 */
trait Translatable
{

    protected $translated = [];

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
    public function getTranslatableAttributes()
    {
        return $this->config('translatable');
    }

    /**
     * @return mixed
     */
    public function getTranslatedAttributes()
    {
        return $this->translated;
    }

    /**
     * @param $attribute
     * @param $value
     * @param $locale
     * @return mixed
     */
    public function saveTranslation($attribute, $value, $locale)
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
    public function translate($locale)
    {
        $this->load('translations');
        foreach ($this->translations->where('locale', $locale) as $translation) {
            //$this->translated[$translation->translatable_column] = $this->getAttribute($translation->translatable_column);
            $this->translated[] = $translation->translatable_column;
            $this->setAttribute($translation->translatable_column, $translation->value);
        }
    }

    public function untranslate()
    {
        foreach ($this->getTranslatedAttributes() as $n => $attribute) {
            $this->setAttribute($attribute, $this->getOriginal($attribute));
            unset($this->translated[$n]);
        }
    }

}