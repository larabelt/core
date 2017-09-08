<?php

namespace Belt\Core\Helpers;

use Belt\Core\Helpers\StrHelper;

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
        $url = StrHelper::normalizeUrl($url);

        return $url;
    }

}