<?php namespace Tests\Belt\Core\Unit\Observers;

use Belt\Core\Behaviors\IncludesLocale;
use Belt\Core\Behaviors\IncludesLocaleInterface;
use Belt\Core\Observers\IncludesLocaleObserver;
use Tests\Belt\Core;
use Mockery as m;

class IncludesLocaleObserverTest extends \Tests\Belt\Core\BeltTestCase
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

class IncludesLocaleObserverStub extends \Tests\Belt\Core\Base\BaseModelStub implements IncludesLocaleInterface
{
    use IncludesLocale;

}