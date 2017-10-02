<?php

namespace Belt\Core\Helpers;

use Sabre\Uri;

/**
 * Class UrlHelper
 * @package Belt\Core\Helpers
 */
class UrlHelper
{

    /**
     * Determine static path
     *
     * @param $path
     * @return string
     */
    public static function staticUrl($path)
    {
        if (!$static_url = env('APP_STATIC_URL')) {
            return url($path);
        }

        $url = sprintf('%s/%s', $static_url, $path);
        $url = self::normalize($url);

        return $url;
    }

    /**
     * @param $str
     * @return string
     */
    public static function normalize($str)
    {
        return rtrim(Uri\normalize($str), '/');
    }

}