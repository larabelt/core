<?php

namespace Belt\Core\Behaviors;

use Translate;
use Belt\Core\Observers\IncludesLocaleObserver;

/**
 * Class IncludesLocale
 * @package Belt\Content\Behaviors
 */
trait IncludesLocale
{

    /**
     * Binds events to subclass
     */
    public static function bootIncludesLocale()
    {
        static::observe(IncludesLocaleObserver::class);
    }

    /**
     * @param $value
     */
    public function setLocaleAttribute($code)
    {
        $this->attributes['locale'] = Translate::isAvailableLocale($code) ? $code : config('app.fallback_locale');
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function getLocaleAttribute($code)
    {
        return $code ?: config('app.fallback_locale');
    }

}