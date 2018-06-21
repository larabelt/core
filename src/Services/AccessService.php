<?php

namespace Belt\Core\Services;

use Auth;

/**
 * Class AccessService
 * @package Belt\Core\Services
 */
class AccessService
{

    /**
     * @var array
     */
    public static $permissions = [
        'roles' => ['*' => null],
        'teams' => ['*' => null],
        'users' => ['*' => null],
    ];

    /**
     * @param $ability
     * @param $model
     */
    public static function put($ability, $model)
    {
        static::$permissions[$model]['*'] = null;
        static::$permissions[$model][$ability] = null;
    }

    /**
     * Save auth user's access map to session
     */
    public function map()
    {

        if (!Auth::user()) {
            return [];
        }

        if (session('access')) {
            return session('access');
        }

        $access = [];

        foreach (static::$permissions as $model => $abilities) {
            foreach ($abilities as $ability => $permissible) {
                $access[$model][$ability] = Auth::user()->can($ability, $model);
                if ($ability = '*' && $access[$model][$ability]) {
                    break;
                }
            }
        }

        session(['access' => $access]);

        return $access;
    }

}