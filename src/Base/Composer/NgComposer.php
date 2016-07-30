<?php namespace Ohio\Core\Base\Composer;

use Ohio;
use Illuminate\Contracts\View\View;

class NgComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {

//        $global_ng = app(Ohio\Core\Base\Service\NgService::class)->all();
//        $controller_ng = array_get($view->getData(), 'ng', []);
//        $ng = array_merge($global_ng, $controller_ng);

        $view->with('ng', app(Ohio\Core\Base\Service\NgService::class)->all());
    }

}