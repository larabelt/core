<?php
namespace Ohio\Core\Base\Helper;

use Illuminate\Database\Eloquent\Builder;

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

}