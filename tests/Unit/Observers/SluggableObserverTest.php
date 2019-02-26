<?php namespace Tests\Belt\Core\Unit\Observers;

use Belt\Core\Behaviors\Sluggable;
use Belt\Core\Behaviors\SluggableInterface;
use Belt\Core\Observers\SluggableObserver;
use Tests\Belt\Core;
use Mockery as m;

class SluggableObserverTest extends \Tests\Belt\Core\BeltTestCase
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

class SluggableObserverStub extends \Tests\Belt\Core\Base\BaseModelStub implements SluggableInterface
{
    use Sluggable;
}