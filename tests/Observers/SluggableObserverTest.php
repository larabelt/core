<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Behaviors\SluggableInterface;
use Belt\Core\Behaviors\Sluggable;
use Belt\Core\Observers\SluggableObserver;

class SluggableObserverTest extends Testing\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Observers\SluggableObserver::saving
     */
    public function test()
    {
        $observer = new SluggableObserver();

        $sluggable = m::mock(SluggableObserverStub::class);
        $sluggable->shouldReceive('slugify')->once()->andReturnSelf();

        $observer->saving($sluggable);
    }

}

class SluggableObserverStub extends Testing\BaseModelStub implements SluggableInterface
{
    use Sluggable;
}