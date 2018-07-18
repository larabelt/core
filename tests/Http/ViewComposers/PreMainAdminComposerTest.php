<?php

use Mockery as m;

use Belt\Core\Http\ViewComposers\PreMainAdminComposer;
use Belt\Core\Testing\BeltTestCase;
use Illuminate\Contracts\View\View;

class PreMainAdminComposerTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\ViewComposers\PreMainAdminComposer::push
     * @covers \Belt\Core\Http\ViewComposers\PreMainAdminComposer::compose
     */
    public function test()
    {
        $composer = new PreMainAdminComposer();
        $composer->push('foo');
        $view = m::mock(View::class);
        $view->shouldReceive('with')->once()->with('includes', ['foo']);
        $composer->compose($view);
    }
}