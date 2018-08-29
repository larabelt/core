<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Behaviors\IncludesSubtypesInterface;
use Belt\Core\Behaviors\IncludesSubtypes;
use Belt\Core\Builders\BaseBuilder;
use Belt\Core\Observers\IncludesSubtypesObserver;

class IncludesSubtypesObserverTest extends Testing\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Observers\IncludesSubtypesObserver::created
     * @covers \Belt\Core\Observers\IncludesSubtypesObserver::saved
     */
    public function test()
    {
        $stub = m::mock(IncludesSubtypesObserverStub::class);
        $stub->shouldReceive('getSubtypeConfig')->with('builder')->andReturn(IncludesSubtypesObserverBuilder::class);
        $stub->shouldReceive('getIsCopy')->andReturn(false);
        $stub->shouldReceive('foo')->once()->andReturnSelf();
        $stub->shouldReceive('reconcileSubtypeParams')->once()->andReturnSelf();

        $observer = new IncludesSubtypesObserver();

        # created
        $observer->created($stub);

        # saved
        $observer->saved($stub);
    }

}

class IncludesSubtypesObserverBuilder extends BaseBuilder
{
    public function build()
    {
        $this->item->foo();
    }

}

class IncludesSubtypesObserverStub extends Testing\BaseModelStub implements IncludesSubtypesInterface
{
    use IncludesSubtypes;

}