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
        $view->with('xng', app(Ohio\Core\Base\Service\NgService::class)->all());
    }

}