<?php namespace Tests\Belt\Core\Unit\Observers;

use Belt\Core\Behaviors\Paramable;
use Belt\Core\Behaviors\ParamableInterface;
use Belt\Core\Observers\ParamableObserver;
use Tests\Belt\Core;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Mockery as m;

class ParamableObserverTest extends \Tests\Belt\Core\BeltTestCase
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

class ParamableObserverStub extends \Tests\Belt\Core\Base\BaseModelStub implements ParamableInterface
{
    use Paramable;
}