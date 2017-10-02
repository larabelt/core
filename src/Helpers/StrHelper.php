<?php

namespace Belt\Core\Helpers;

use Belt\Core\Helpers\UrlHelper;

/**
 * Class StrHelper
 * @package Belt\Core\Helpers
 */
class StrHelper
{

    /**
     * @param $s
     * @return bool
     */
    public static function isJson($s)
    {
        json_decode($s);

        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * @param $expression
     * @param $count
     * @return array
     */
    public static function strToArguments($expression, $count = 1)
    {
        $arguments = [];
        foreach (explode(',', $expression) as $str) {
            $str = trim($str, "' ");
            $argument = static::strToArray($str) ?: $str;
            $arguments[] = $argument;
        }

        while (count($arguments) < $count) {
            $arguments[] = null;
        }

        return $arguments;
    }

    /**
     * @todo change this away from eval()
     * @source http://stackoverflow.com/questions/11267434/php-how-to-turn-a-string-that-contains-an-array-expression-in-an-actual-array/18187993#18187993
     * @param $str
     * @return mixed
     */
    public static function strToArray($str)
    {
        // @codeCoverageIgnoreStart
        if (!function_exists("token_get_all")) {
            return false;
        }
        // @codeCoverageIgnoreEnd

        $code = "return $str;";

        $tokens = token_get_all("<?php $code ?>");

        foreach ($tokens as $token) {

            $type = $token[0];

            if (is_long($type)) {
                if (in_array($type, [
                    T_OPEN_TAG,
                    T_RETURN,
                    T_WHITESPACE,
                    T_ARRAY,
                    T_LNUMBER,
                    T_DNUMBER,
                    T_CONSTANT_ENCAPSED_STRING,
                    T_DOUBLE_ARROW,
                    T_CLOSE_TAG,
                    T_NEW,
                    T_DOUBLE_COLON,
                ])) {
                    continue;
                }

                return false;
            }
        }

        $array = eval($code);

        return is_array($array) ? $array : false;
    }

    /**
     * @deprecated
     * @param $str
     * @return string
     */
    public static function normalizeUrl($str)
    {
        return UrlHelper::normalize($str);
    }

}