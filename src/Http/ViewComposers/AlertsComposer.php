<?php
namespace Belt\Core\Http\ViewComposers;

use Cache, Cookie;
use Belt\Core\Alert;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class AlertsComposer
{
    /**
     * @var Alert[]|Collection
     */
    protected $alerts;

    /**
     * Create a new profile composer.
     */
    public function __construct()
    {
        $alerts = Cache::get('alerts');

        if ($alerts && $alerts->count() && $alerts instanceof Collection) {

            $dismissed = Cookie::get('alerts') ?: '';
            $dismissed = array_unique(explode(',', $dismissed));

            foreach ($dismissed as $id) {
                $alerts->forget($id);
            }

            $this->alerts = $alerts;
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
        $view->with('alerts', $this->alerts);
    }
}