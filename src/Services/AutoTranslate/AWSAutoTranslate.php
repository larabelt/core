<?php

namespace Belt\Core\Services\AutoTranslate;

use Belt;

/**
 * Class AWSAutoTranslate
 * @package Belt\Core\Services
 */
class AWSAutoTranslate extends Belt\Core\Services\AutoTranslate\BaseAutoTranslate
{
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

        $client = new \Aws\Translate\TranslateClient([
            'version' => 'latest',
            'region' => 'us-east-2'
        ]);

        $result = $client->translateText([
            'SourceLanguageCode' => $source_locale, // REQUIRED
            'TargetLanguageCode' => $target_locale, // REQUIRED
            'Text' => $text, // REQUIRED
        ]);

        return $result->get('TranslatedText');
    }

}