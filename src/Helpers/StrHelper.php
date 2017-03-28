<?php

namespace Belt\Core\Helpers;

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
     * @codeCoverageIgnore
     */
    public static function strToArray1($str)
    {

//        s(unserialize($str));

        $array = array();
        $tokens = token_get_all("<?php $str");

        s(token_get_all("<?php array('foo'=>'bar')"));
        s(token_get_all("<?php ['foo'=>'bar',]"));

//        if ($tokens[1][0] != T_ARRAY || $tokens[2] != '(' || end($tokens) != ')') {
//            return null;
//        }
//
//        for ($i = 3; $i < count($tokens) - 1; $i += 2) {
//            if (count($tokens[$i]) != 3) {
//                s(111);
//                return null;
//            }
//
//            if ($tokens[$i][0] == T_WHITESPACE) {
//                $i--;
//                continue;
//            }
//
//            if ($tokens[$i][0] == T_VARIABLE || $tokens[$i][0] == T_STRING) {
//                s(222);
//                return null;
//            }
//
//            $value = $tokens[$i][1];
//            if ($tokens[$i][0] == T_CONSTANT_ENCAPSED_STRING) {
//                $value = substr($value, 1, strlen($value) - 2);
//            }
//
//            $array[] = $value;
//
//            if ($tokens[$i + 1] != ',' && $tokens[$i + 1] != ')' && $tokens[$i + 1][0] != T_WHITESPACE) {
//                s(333);
//                s($tokens[$i]);
//                s($tokens[$i + 1]);
//                s($tokens[$i + 1][0]);
//                s(T_WHITESPACE);
//                return null;
//            }
//        }
//
//        s(999);
//        s($array);
//
//        return $array;
    }

    /**
     * @codeCoverageIgnore
     */
    public static function strToArray9($str)
    {

        /**
         * 379 T_OPEN_TAG
         * 348 T_RETURN
         * 382 T_WHITESPACE
         * 368 T_ARRAY
         * 318 T_DNUMBER
         * 323 T_CONSTANT_ENCAPSED_STRING
         * 268 T_DOUBLE_ARROW
         * 381 T_CLOSE_TAG
         * 305 T_NEW
         * 387 T_DOUBLE_COLON
         */

//        if (!function_exists("token_get_all")) {
//            return false;
//        }
//
//        $tokens = token_get_all('<?php ' . trim($str));
//        s($tokens);
//
//        // check if str opens as "array(" or "["
//        if ($tokens[1][0] != '[' && ($tokens[1][0] != T_ARRAY && $tokens[2] != '(')) {
//            return false;
//        }
//
//        // check if str closes as ")" or "]"
//        $last = array_values(array_slice($tokens, -1))[0];
//        if ($last != ')' && $last != ']') {
//            return false;
//        }

        $test = function ($str) {
            s(111);
            s($str);
        };

        ob_start();
        echo json_encode(trim($str, "'\" "));
        $output = ob_get_clean();

        s($output);
        s(json_decode($output));

        ob_start();
        echo json_encode(array("foo", 2));
        $output = ob_get_clean();

        s($output);
        s(json_decode($output));

        $array = [];

//        $strip = function ($str) {
//            return trim($str, "'\" ");
//        };
//
//        $str = str_replace(['array(', '(', '[', ']', ')'], '', $str);
//
//        foreach (explode(',', $str) as $line) {
//            $values = explode('=>', $line);
//            if (count($values) == 2) {
//                $array[$strip($values[0])] = $strip($values[1]);
//            }
//            if (count($values) == 1) {
//                $array[] = $strip($values[0]);
//            }
//        }

        s(999);
        s($array);

        return $array;
    }

}