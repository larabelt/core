<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Behaviors\ParamableInterface;
use Belt\Core\Behaviors\Paramable;
use Belt\Core\Observers\ParamableObserver;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ParamableObserverTest extends Testing\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Observers\ParamableObserver::deleting
     */
    public function test()
    {
        $observer = new ParamableObserver();

        $relation = m::mock(MorphMany::class);
        $relation->shouldReceive('delete')->once();

        $paramable = m::mock(ParamableObserverStub::class);
        $paramable->shouldReceive('params')->once()->andReturn($relation);

        $observer->deleting($paramable);
    }

}

class ParamableObserverStub extends Testing\BaseModelStub implements ParamableInterface
{
    use Paramable;
}