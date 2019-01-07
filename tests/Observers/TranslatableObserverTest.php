<?php

use Mockery as m;
use Belt\Core\Testing;
use Belt\Core\Behaviors\TranslatableInterface;
use Belt\Core\Behaviors\Translatable;
use Belt\Core\Observers\TranslatableObserver;
use Belt\Core\Facades\TranslateFacade as Translate;

class TranslatableObserverTest extends Testing\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Observers\TranslatableObserver::retrieved
     * @covers \Belt\Core\Observers\TranslatableObserver::saving
     * @covers \Belt\Core\Observers\TranslatableObserver::saved
     */
    public function test()
    {

        $translatable = m::mock(TranslatableObserverStub::class);

        $observer = new TranslatableObserver();

        # retrieved
        $translatable->shouldReceive('translate')->once()->with('es_ES')->andReturnSelf();
        Translate::shouldReceive('getAlternateLocale')->andReturn('es_ES');
        Translate::shouldReceive('canTranslateObjects')->andReturn(true);
        $observer->retrieved($translatable);

        # saving
        $translatable->shouldReceive('untranslate')->once()->andReturnSelf();
        $observer->saving($translatable);

        # saved
        $translatable->shouldReceive('retranslate')->once()->andReturnSelf();
        $observer->saved($translatable);

    }

}

class TranslatableObserverStub extends Testing\BaseModelStub implements TranslatableInterface
{
    use Translatable;
}