<?php

use Mockery as m;
use Belt\Core\Behaviors\HasConfig;
use Belt\Core\Behaviors\Translatable;
use Belt\Core\Translation;
use Belt\Core\Team;
use Belt\Core\Testing;
use Belt\Core\Facades\MorphFacade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class TranslatableTest extends Testing\BeltTestCase
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
        

        return;

        # translation
        $this->assertEquals('bar', $stub->translation('foo'));
        $this->assertEquals('default', $stub->translation('missing', 'default'));
        $this->assertEquals(null, $stub->translation('invalid'));

        # hasTranslation
        $this->assertTrue($stub->hasTranslation('hello'));
        $this->assertFalse($stub->hasTranslation('world'));

        # saveTranslation (create/update)
        $translation = m::mock(Translation::class . '[save]');
        $translation->shouldReceive('save')->once()->andReturnSelf();
        $morphMany = m::mock(MorphMany::class);
        $morphMany->shouldReceive('firstOrNew')->once()->andReturn($translation);
        $stub = m::mock(TranslatableStub::class . '[translations]');

        $stub::bootTranslatable();
        $stub->translations = new Collection();
        $stub->shouldReceive('translations')->once()->andReturn($morphMany);
        $stub->saveTranslation('missing', 'test');

        # purgeDuplicateTranslations
        Translation::unguard();
        $translation = new Translation(['id' => 1, 'key' => 'foo', 'value' => 'bar']);
        $duplicate = m::mock(Translation::class);
        $duplicate->shouldReceive('delete')->once()->andReturnNull();

        $duplicates = new Collection();
        $duplicates->add($duplicate);

        $translationQB = m::mock(Builder::class);
        $translationQB->shouldReceive('where')->once()->with('id', '!=', 1)->andReturnSelf();
        $translationQB->shouldReceive('where')->once()->with('translatable_type', 'translatable-stubs')->andReturnSelf();
        $translationQB->shouldReceive('where')->once()->with('translatable_id', 999)->andReturnSelf();
        $translationQB->shouldReceive('where')->once()->with('key', 'foo')->andReturnSelf();
        $translationQB->shouldReceive('get')->once()->andReturn($duplicates);

        $stub = m::mock(TranslatableStub::class . '[translationQB,getAttribute]');
        $stub->shouldReceive('translationQB')->once()->andReturn($translationQB);
        $stub->shouldReceive('getAttribute')->with('id')->andReturn(999);
        $stub->shouldReceive('getAttribute')->with('key')->andReturn('test');
        $stub->purgeDuplicateTranslations($translation);

        # morphTranslation
        $team = factory(Team::class)->make();
        MorphFacade::shouldReceive('morph')->once()->with('teams', 1)->andReturn($team);
        $stub = m::mock(TranslatableStub::class . '[translation]');
        $stub->shouldReceive('translation')->once()->with('teams')->andReturn(1);
        $this->assertEquals($team, $stub->morphTranslation('teams'));

        # morphTranslation (exception)
        $stub = m::mock(TranslatableStub::class . '[translation]');
        $stub->shouldReceive('translation')->once()->with('teams')->andReturn(false);
        try {
            $stub->morphTranslation('teams');
            $this->exceptionNotThrown();
        } catch (\Exception $e) {

        }

        # scopeHasDefinedTranslation
        $stub = new TranslatableStub();
        $qb = m::mock(Builder::class);
        $qb->shouldReceive('whereHas')->once()->with('translations',
            m::on(function (\Closure $closure) {
                $qb = m::mock(Builder::class);
                $qb->shouldReceive('where')->with('translations.key', 'test');
                $qb->shouldReceive('where')->with('translations.value', '!=', '');
                $qb->shouldReceive('whereNotNull')->with('translations.value');
                $closure($qb);
                return is_callable($closure);
            })
        );
        $stub->scopeHasDefinedTranslation($qb, 'test');

        # scopeHasTranslation
        $stub = new TranslatableStub();
        $qb = m::mock(Builder::class);
        $qb->shouldReceive('whereHas')->once()->with('translations',
            m::on(function (\Closure $closure) {
                $qb = m::mock(Builder::class);
                $qb->shouldReceive('where')->with('translations.key', 'foo');
                $qb->shouldReceive('where')->with('translations.value', 'bar');
                $closure($qb);
                return is_callable($closure);
            })
        );
        $stub->scopeHasTranslation($qb, 'foo', 'bar');

        # getTranslationConfig
        $this->assertEquals([], $stub->getTranslationConfig());

        # getTranslationGroupsConfig
        $this->assertEquals([], $stub->getTranslationGroupsConfig());

    }

}

class TranslatableStub extends Testing\BaseModelStub
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