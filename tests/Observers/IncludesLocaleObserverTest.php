<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Behaviors\IncludesLocaleInterface;
use Belt\Core\Behaviors\IncludesLocale;
use Belt\Core\Observers\IncludesLocaleObserver;

class IncludesLocaleObserverTest extends Testing\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Observers\IncludesLocaleObserver::saving
     */
    public function test()
    {
        $stub = new IncludesLocaleObserverStub();

        $observer = new IncludesLocaleObserver();

        # saving
        $observer->saving($stub);
        $this->assertEquals(config('app.fallback_locale'), $stub->locale);
    }

}

class IncludesLocaleObserverStub extends Testing\BaseModelStub implements IncludesLocaleInterface
{
    use IncludesLocale;

}