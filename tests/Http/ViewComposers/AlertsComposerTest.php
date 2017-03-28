<?php

use Mockery as m;

use Belt\Core\Alert;
use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Http\ViewComposers\AlertsComposer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class AlertsComposerTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\ViewComposers\AlertsComposer::__construct()
     * @covers \Belt\Core\Http\ViewComposers\AlertsComposer::compose()
     */
    public function test()
    {
        Alert::unguard();

        $alerts = new Collection([
            new Alert(['id' => 1]),
            new Alert(['id' => 2]),
            new Alert(['id' => 3]),
        ]);

        Cache::shouldReceive('get')->once()->with('alerts')->andReturn($alerts);
        $this->app['request']->cookies->set('alerts', '1,2');

        # constructor
        $composer = new AlertsComposer();
        $this->assertEquals(1, count($composer->alerts));

        # compose
        $view = m::mock(\Illuminate\View\View::class);
        $view->shouldReceive('with')->once()->with('alerts', $composer->alerts);
        $composer->compose($view);
    }

}