<?php

use Mockery as m;
use Belt\Core\Facades\MorphFacade as Morph;
use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Http\Controllers\Behaviors\Morphable;
use Illuminate\Routing\Controller;

class MorphableTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Controllers\Behaviors\Morphable::morphable
     */
    public function test()
    {
        $controller = new MorphableControllerStub();

        # morphable
        $morphableStub = new MorphableModelStub();
        Morph::shouldReceive('morph')->withArgs(['pages', 1])->andReturn($morphableStub);
        Morph::shouldReceive('morph')->withArgs(['pages', 2])->andThrow(new \Exception());
        $this->assertEquals($morphableStub, $controller->morph('pages', 1));
        try {
            $controller->morph('pages', 2);
            $this->exceptionNotThrown();
        } catch (\Exception $e) {

        }

    }

}

class MorphableModelStub
{

}

class MorphableControllerStub extends Controller
{
    use Morphable;
}