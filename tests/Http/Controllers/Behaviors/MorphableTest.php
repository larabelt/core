<?php

use Mockery as m;
use Belt\Core\Team;
use Belt\Core\Helpers\MorphHelper;
use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Http\Controllers\Behaviors\Morphable;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class MorphableTest extends BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Http\Controllers\Behaviors\Morphable::morphHelper
     * @covers \Belt\Core\Http\Controllers\Behaviors\Morphable::morphable
     * @covers \Belt\Core\Http\Controllers\Behaviors\Morphable::morphableContains
     * @covers \Belt\Core\Http\Controllers\Behaviors\Morphable::morphRequest
     */
    public function test()
    {
        $controller = new MorphableControllerStub();

        # morphHelper
        $this->assertInstanceOf(MorphHelper::class, $controller->morphHelper());

        # morphable
        $morphableStub = new MorphableModelStub();
        $morphHelper = m::mock(MorphHelper::class);
        $morphHelper->shouldReceive('morph')->withArgs(['pages', 1])->andReturn($morphableStub);
        $morphHelper->shouldReceive('morph')->withArgs(['pages', 2])->andThrow(new \Exception());
        $controller->morphHelper = $morphHelper;
        $this->assertEquals($morphableStub, $controller->morphable('pages', 1));
        try {
            $controller->morphable('pages', 2);
            $this->exceptionNotThrown();
        } catch (\Exception $e) {

        }

        # morphRequest
        $request = new Request(['testable_type' => 'pages', 'testable_id' => 1]);
        $this->assertEquals($morphableStub, $controller->morphRequest($request, 'testable'));
        $this->assertNull($controller->morphRequest($request, 'invalid'));

        # morphContains
        Team::unguard();
        $team1 = factory(Team::class)->make(['id' => 1]);
        $team2 = factory(Team::class)->make(['id' => 2]);
        $morphableStub->test = new Collection([$team1]);
        $controller->morphableContains($morphableStub, 'test', $team1);
        try {
            $controller->morphableContains($morphableStub, 'test', $team2);
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