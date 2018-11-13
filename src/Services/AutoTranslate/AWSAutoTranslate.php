<?php

namespace Belt\Core\Services\AutoTranslate;

use Belt;

/**
 * Class AWSAutoTranslate
 * @package Belt\Core\Services
 */
class AWSAutoTranslate extends Belt\Core\Services\AutoTranslate\BaseAutoTranslate
{
    public $client;

    public function client()
    {
        return $this->client ?: $this->client = new \Aws\Translate\TranslateClient([
            'version' => 'latest',
            'region' => 'us-east-2'
        ]);
    }

    /**
     * @param $text
     * @param $target_locale
     * @param $source_locale
     * @return \Aws\Result
     */
    public function translate($text, $target_locale, $source_locale)
    {
        $source_locale = substr($source_locale, 0, 2);
        $target_locale = substr($target_locale, 0, 2);

        $sections = strlen($text) >= 5000 ? $this->split($text, 3000) : [$text];

        $translated_text = '';
        foreach ($sections as $section) {
            $translated_text .= $this->__translate($section, $target_locale, $source_locale);
        }

        return $translated_text;
    }

    /**
     * @param $text
     * @param $target_locale
     * @param $source_locale
     * @return mixed|null
     */
    private function __translate($text, $target_locale, $source_locale)
    {
        $result = $this->client()->translateText([
            'SourceLanguageCode' => $source_locale, // REQUIRED
            'TargetLanguageCode' => $target_locale, // REQUIRED
            'Text' => $text, // REQUIRED
        ]);

        return $result->get('TranslatedText');
    }

}