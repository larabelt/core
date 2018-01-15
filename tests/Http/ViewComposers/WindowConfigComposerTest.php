<?php

use Mockery as m;

use Belt\Core\Helpers\WindowConfigHelper;
use Belt\Core\Http\ViewComposers\WindowConfigComposer;
use Belt\Core\Testing\BeltTestCase;
use Belt\Core\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class WindowConfigComposerTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\ViewComposers\WindowConfigComposer::__construct
     * @covers \Belt\Core\Http\ViewComposers\WindowConfigComposer::middleware
     * @covers \Belt\Core\Http\ViewComposers\WindowConfigComposer::setup
     * @covers \Belt\Core\Http\ViewComposers\WindowConfigComposer::compose
     */
    public function test()
    {
        # __construct, middleware
        $middleware = ['web'];
        $current = m::mock(Illuminate\Routing\Route::class);
        $current->shouldReceive('middleware')->andReturn($middleware);
        Route::shouldReceive('current')->andReturn($current);
        new WindowConfigComposer();

        # setup
        $user = factory(User::class)->make();
        Auth::shouldReceive('user')->andReturn($user);
        WindowConfigHelper::$config['auth'] = [];
        $composer = new WindowConfigComposer();
        $composer->middleware = ['admin'];
        $composer->setup();
        $this->assertEquals($user->email, WindowConfigHelper::$config['auth']['email']);

        # compose
        $composer = new WindowConfigComposer();
        $json = WindowConfigHelper::json();
        $view = m::mock(View::class);
        $view->shouldReceive('with')->once()->with('windowConfig', $json);
        $composer->compose($view);
    }
}