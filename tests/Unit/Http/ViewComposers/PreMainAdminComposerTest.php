<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\ViewComposers\PreMainAdminComposer;
use Illuminate\Contracts\View\View;
use Mockery as m;

class PreMainAdminComposerTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\ViewComposers\PreMainAdminComposer::push
     * @covers \Belt\Core\Http\ViewComposers\PreMainAdminComposer::all
     * @covers \Belt\Core\Http\ViewComposers\PreMainAdminComposer::compose
     */
    public function test()
    {
        $composer = new PreMainAdminComposer();

        # push
        $composer->push('foo');

        # all
        $includes = $composer->all();
        $this->assertTrue(in_array('foo', $includes));

        # compose
        $view = m::mock(View::class);
        $view->shouldReceive('with')->once()->with('includes', $includes);
        $composer->compose($view);
    }
}