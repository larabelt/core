<?php namespace Tests\Belt\Core\Unit\Observers;

use Belt\Core\Behaviors\Translatable;
use Belt\Core\Behaviors\TranslatableInterface;
use Belt\Core\Facades\TranslateFacade as Translate;
use Belt\Core\Observers\TranslatableObserver;
use Tests\Belt\Core;
use Mockery as m;

class TranslatableObserverTest extends \Tests\Belt\Core\BeltTestCase
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

class TranslatableObserverStub extends \Tests\Belt\Core\Base\BaseModelStub implements TranslatableInterface
{
    use Translatable;
}