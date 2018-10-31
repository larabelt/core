<?php

namespace Belt\Core\Services;

use App, Belt, Cookie;
use Belt\Core\Behaviors\HasConfig;

/**
 * Class TranslateService
 * @package Belt\Core\Services
 */
class TranslateService
{
    use HasConfig;

    protected static $translateObjects = false;

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
    public function setLocale($code)
    {
        if ($this->isAvailableLocale($code)) {
            App::setLocale($code);
            Cookie::queue(Cookie::make('locale', $code, 86400 * 365, null, null, false, false));
        }
    }

    /**
     * @return mixed
     */
    public function getLocaleFromRequest($request)
    {
        $code = $request->get('locale') ?? $request->segments()[0];

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
     * @todo abstract this
     * @param $target
     * @param $text
     * @param $source
     * @return \Aws\Result
     */
    public function translate($target, $text, $source = 'en')
    {
        $source = $source ?: config('app.fallback_locale');
        $source = substr($source, 0, 2);
        $target = substr($target, 0, 2);

        $client = new \Aws\Translate\TranslateClient([
            'version' => 'latest',
            'region' => 'us-east-2'
        ]);

        $result = $client->translateText([
            'SourceLanguageCode' => $source, // REQUIRED
            'TargetLanguageCode' => $target, // REQUIRED
            'Text' => $text, // REQUIRED
        ]);

        return $result->get('TranslatedText');
    }

}