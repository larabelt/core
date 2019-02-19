<?php

use Mockery as m;

use Belt\Core\Http\ViewComposers\DocsComposer;
use Belt\Core\Testing\BeltTestCase;
use Illuminate\Contracts\View\View;

class DocsComposerTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\ViewComposers\DocsComposer::compose
     */
    public function test()
    {
        app()['config']->set('belt.docs.vars', [
            'foo' => 'bar',
        ]);

        # compose
        $view = m::mock(View::class);
        $view->shouldReceive('getData')->once()->andReturn([]);
        $view->shouldReceive('with')->once()->with('version', '2.0');
        $view->shouldReceive('with')->once()->with('foo', 'bar');
        $composer = new DocsComposer();
        $composer->compose($view);
    }
}