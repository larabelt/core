<?php
namespace Ohio\Base\Helper;

use DB;

/**
 * Class DebugHelper
 *
 * @package TN\Cms\Helper
 */
class DebugHelper
{

    public static function enableQueryLog()
    {
        DB::enableQueryLog();
    }

    public static function getLastQuery()
    {
        //needs DB::enableQueryLog(); before this is run;

        $queries = DB::getQueryLog();
        $sql = end($queries);

        if (!empty($sql['bindings'])) {
            $pdo = DB::getPdo();
            foreach ($sql['bindings'] as $binding) {
                $sql['query'] =
                    preg_replace('/\?/', $pdo->quote($binding),
                        $sql['query'], 1);
            }
        }

        return $sql['query'];
    }


}