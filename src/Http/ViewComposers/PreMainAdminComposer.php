<?php

namespace Belt\Core\Http\ViewComposers;

use Belt;
use Illuminate\Contracts\View\View;

class PreMainAdminComposer
{

    /**
     * @var array
     */
    protected static $includes = [];

    /**
     * @param $path
     */
    public static function push($path)
    {
        if (!in_array($path, static::$includes)) {
            static::$includes[] = $path;
        }
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('includes', static::$includes);
    }

}