<?php

namespace Belt\Core\Services;

use App, Belt;
use Belt\Core\Behaviors\HasConfig;

/**
 * Class TranslateService
 * @package Belt\Core\Services
 */
class TranslateService
{
    use HasConfig;

    /**
     * @return string
     */
    public function configPath()
    {
        return 'belt.core.translate';
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return App::getLocale();
    }

    /**
     * @param $lang
     */
    public function setLocale($locale)
    {
        if (in_array($locale, (array) $this->config('locales'))) {
            App::setLocale($locale);
        }
    }

    /**
     * @return mixed
     */
    public function getAlternateLocale()
    {
        $locale = $this->getLocale();
        if ($locale != config('app.fallback_locale')) {
            return $locale;
        }
    }

}