<?php

namespace Belt\Core\Services;

use App, Belt, Cookie;
use Belt\Core\Behaviors;

/**
 * Class TranslateService
 * @package Belt\Core\Services
 */
class TranslateService
{
    use Behaviors\CanEnable, Behaviors\HasConfig;

    protected static $translateObjects = false;

    /**
     * TranslateService constructor.
     */
    public function __construct()
    {
        if (count($this->getAvailableLocales()) > 1) {
            static::enable();
        }
    }

    /**
     * @return string
     */
    public function configPath()
    {
        return 'belt.core.translate';
    }

    public static function active()
    {
        return static::active();
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
    public function setLocale($code)
    {
        if ($this->isAvailableLocale($code)) {
            App::setLocale($code);
            $this->setLocaleCookie($code);
        }
    }

    /**
     * @param $lang
     */
    public function setLocaleCookie($code)
    {
        Cookie::queue(Cookie::make('locale', $code, 86400 * 365, null, null, false, false));
    }

    /**
     * @return mixed
     */
    public function getLocaleCookie()
    {
        if ($cookie = Cookie::queued('locale')) {
            return $cookie->getValue();
        }

        return Cookie::get('locale');
    }

    /**
     * @return mixed
     */
    public function prefixUrls(): bool
    {
        return $this->config('prefix-urls');
    }

    /**
     * @return mixed
     */
    public function getLocaleFromRequest($request)
    {
        //$code = $request->get('locale') ?? $request->segment(1);

        $code = $request->get('locale');

        if (!$code && $this->prefixUrls()) {
            $code = $request->segment(1);
        }

        if ($code && $this->isAvailableLocale($code)) {
            return $code;
        }
    }

    /**
     * @param $code
     * @return bool
     */
    public function isAvailableLocale($code)
    {
        return array_first($this->getAvailableLocales(), function ($locale) use ($code) {
            return array_get($locale, 'code') == $code;
        });
    }

    /**
     * @param $locale
     * @return bool
     */
    public function getAvailableLocales()
    {
        return $this->config('locales');
    }

    /**
     * @return mixed
     */
    public function getAlternateLocale()
    {
        $code = $this->getLocale();

        if ($code != config('app.fallback_locale') && $this->isAvailableLocale($code)) {
            return $code;
        }
    }

    /**
     * @return mixed
     */
    public function getAlternateLocales()
    {
        $locales = [];

        foreach ($this->getAvailableLocales() as $locale) {
            if ($locale['code'] != config('app.fallback_locale')) {
                $locales[] = $locale;
            }
        }

        return $locales;
    }

    /**
     * @param $value
     */
    public static function setTranslateObjects($value)
    {
        static::$translateObjects = $value;
    }

    /**
     * @return bool
     */
    public static function canTranslateObjects()
    {
        return static::$translateObjects;
    }

    /**
     * @param $text
     * @param $target_locale
     * @param $source_locale
     * @return \Aws\Result
     */
    public function translate($text, $target_locale = null, $source_locale = null)
    {
        $source_locale = $source_locale ?: config('app.fallback_locale');
        $target_locale = $target_locale ?: $this->getAlternateLocale();

        $driver_class = $this->config('auto-translate.driver');

        $driver = new $driver_class($this);

        return $driver->translate($text, $target_locale, $source_locale);
    }

}