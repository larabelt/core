<?php

namespace Belt\Core\Helpers;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class DebugHelper
 * @package Belt\Core\Helpers
 */
class DebugHelper
{

    /**
     * http://stackoverflow.com/a/37289496/1662866
     *
     * @param Builder $qb
     * @return mixed
     */
    public static function getSql(Builder $qb)
    {
        $replace = function ($sql, $bindings) {
            $needle = '?';
            foreach ($bindings as $replace) {
                $pos = strpos($sql, $needle);
                if ($pos !== false) {
                    $sql = substr_replace($sql, $replace, $pos, strlen($needle));
                }
            }
            return $sql;
        };

        $sql = $replace($qb->toSql(), $qb->getBindings());

        return $sql;
    }

    /**
     * @param $contents
     * @return string
     */
    public static function buffer($contents)
    {

        $cli = php_sapi_name() == 'cli' ? true : false;

        ob_start();
        if (!is_object($contents) && !is_array($contents)) {
            echo $contents;
        } else {
            echo $cli ? '' : '<pre>';
            print_r($contents);
            echo $cli ? '' : '</pre>';
        }
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    /**
     * @param $data
     * @param bool $return
     * @return mixed
     * @credit https://stackoverflow.com/a/35207172/1662866
     */
    public static function varExportShort($data, $return = true)
    {
        $dump = var_export($data, true);

        $dump = preg_replace('#(?:\A|\n)([ ]*)array \(#i', '[', $dump); // Starts
        $dump = preg_replace('#\n([ ]*)\),#', "\n$1],", $dump); // Ends
        $dump = preg_replace('#=> \[\n\s+\],\n#', "=> [],\n", $dump); // Empties

        if (gettype($data) == 'object') { // Deal with object states
            $dump = str_replace('__set_state(array(', '__set_state([', $dump);
            $dump = preg_replace('#\)\)$#', "])", $dump);
        } else {
            $dump = preg_replace('#\)$#', "]", $dump);
        }

        if ($return === true) {
            return $dump;
        } else {
            echo $dump;
        }
    }

}