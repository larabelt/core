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
     * @return array
     */
    public static function all()
    {
        return static::$includes;
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('includes', static::all());
    }

}