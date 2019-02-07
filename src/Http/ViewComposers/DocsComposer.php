<?php

namespace Belt\Core\Http\ViewComposers;

use Belt;
use Illuminate\Contracts\View\View;

class DocsComposer
{

    use Belt\Core\Behaviors\HasService;

    /**
     * @var string
     */
    protected $serviceClass = Belt\Core\Services\DocsService::class;

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     * @throws \Exception
     */
    public function compose(View $view)
    {
        if (!array_get($view->getData(), 'version')) {
            $bits = explode('.', Belt\Core\BeltCoreServiceProvider::VERSION);
            $view->with('version', implode('.', [$bits[0], $bits[1]]));
        }

        foreach ($this->service()->config('vars') as $key => $value) {
            $view->with($key, $value);
        }
    }

}