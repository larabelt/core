<?php namespace Tests\Belt\Core\Unit\Behaviors;

use Belt\Core\Behaviors\HasConfig;
use Belt\Core\Behaviors\Translatable;
use Tests\Belt\Core;
use Belt\Core\Translation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Mockery as m;

class TranslatableTest extends \Tests\Belt\Core\BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Behaviors\Translatable::bootTranslatable
     * @covers \Belt\Core\Behaviors\Translatable::translations
     * @covers \Belt\Core\Behaviors\Translatable::getTranslatableAttributes
     * @covers \Belt\Core\Behaviors\Translatable::getTranslatedAttributes
     * @covers \Belt\Core\Behaviors\Translatable::saveTranslation
     * @covers \Belt\Core\Behaviors\Translatable::translate
     * @covers \Belt\Core\Behaviors\Translatable::untranslate
     * @covers \Belt\Core\Behaviors\Translatable::retranslate
     */
    public function test()
    {
        $this->enableI18n();

        app()['config']->set('belt.TranslatableStub', [
            'translatable' => [
                'name',
                'body',
            ]
        ]);

        // init
        TranslatableStub::unguard();
        Translation::unguard();
        $stub = new TranslatableStub();

        // set up translations
        $stub->translations = new Collection();
        $stub->translations->add(new Translation([
                'locale' => 'es_ES',
                'translatable_column' => 'name',
                'value' => 'foo name',
            ]
        ));
        $stub->translations->add(new Translation([
                'locale' => 'es_ES',
                'translatable_column' => 'body',
                'value' => 'foo body',
            ]
        ));

        # bootTranslatable
        TranslatableStub::bootTranslatable();

        # translations
        $this->assertInstanceOf(MorphMany::class, $stub->translations());

        # getTranslatableAttributes
        $this->assertEquals(['name', 'body'], $stub->getTranslatableAttributes());

        # translate
        $stub->translate('es_ES');
        $this->assertEquals('foo name', array_get($stub->getTranslatedAttributes(), 'name'));
        $this->assertEquals('foo name', $stub->name);


        # untranslate
        $stub->untranslate();
        $this->assertEquals('original name', $stub->name);

        # retranslate
        $stub->retranslate();
        $this->assertEquals('foo name', $stub->name);

        # saveTranslation

        $translation = factory(Translation::class)->make([
            'locale' => 'es_ES',
            'translatable_column' => 'name',
            'value' => 'new value'
        ]);

        $translationsQB = m::mock(Builder::class);
        $translationsQB->shouldReceive('updateOrCreate')->once()->with(
            ['locale' => 'es_ES', 'translatable_column' => 'name'],
            ['value' => 'new value']
        )->andReturn($translation);

        $stub = m::mock(TranslatableStub::class . '[translations]');
        $stub->shouldReceive('translations')->andReturn($translationsQB);

        $this->assertEquals($translation, $stub->saveTranslation('name', 'new value', 'es_ES'));
    }

}

class TranslatableStub extends \Tests\Belt\Core\Base\BaseModelStub
{
    use HasConfig;
    use Translatable;

    /**
     * Sync the original attributes with the current.
     *
     * @return $this
     */
    public function syncOriginal()
    {
        $this->original = [
            'name' => 'original name',
            'body' => 'original body',
        ];

        return $this;
    }

    public function load($relations)
    {

    }

    /**
     * @return string
     */
    public function configPath()
    {
        return 'belt.TranslatableStub';
    }

    public function getMorphClass()
    {
        return 'translatable-stubs';
    }

}