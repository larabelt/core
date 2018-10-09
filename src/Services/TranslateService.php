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
        $locales = array_keys((array) $this->config('locales'));

        if (in_array($locale, $locales)) {
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

    /**
     * @todo abstract this
     * @param $source
     * @param $target
     * @param $text
     * @return \Aws\Result
     */
    public function translate($source = 'en', $target, $text)
    {
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

        return $result;
    }

}