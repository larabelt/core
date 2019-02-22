<?php namespace Tests\Belt\Core\Unit\Commands;

use Belt\Core\Behaviors\HasConfig;
use Belt\Core\Behaviors\Paramable;
use Belt\Core\Behaviors\Translatable;
use Belt\Core\Commands\TranslateCommand;
use Belt\Core\Facades\MorphFacade as Morph;
use Belt\Core\Facades\TranslateFacade as Translate;
use Belt\Core\Jobs\TranslateValue;
use Belt\Core\Tests\BeltTestCase;
use Belt\Core\Translation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Queue;
use Mockery as m;

class TranslateCommandTest extends BeltTestCase
{

    public function tearDown()
    {
        m::close();
    }

    public function setUp()
    {
        parent::setUp();

        $this->enableI18n();

        \Queue::fake();

        StubTranslateCommandTest::unguard();
        StubTranslateCommandTestParam::unguard();

        app()['config']->set('belt.StubTranslateCommandTest', [
            'translatable' => [
                'name',
                'body',
            ],
            'params' => [
                'foo' => [
                    'translatable' => true,
                ]
            ]
        ]);

    }

    /**
     * @covers \Belt\Core\Commands\TranslateCommand::handle
     * @covers \Belt\Core\Commands\TranslateCommand::attributes
     * @covers \Belt\Core\Commands\TranslateCommand::ids
     * @covers \Belt\Core\Commands\TranslateCommand::locales
     * @covers \Belt\Core\Commands\TranslateCommand::types
     */
    public function test()
    {
        $cmd = m::mock(TranslateCommand::class . '[option]');

        # types
        $cmd->shouldReceive('option')->with('type', '')->andReturn('pages,blocks');
        $this->assertEquals(['pages', 'blocks'], $cmd->types());

        # attributes
        $cmd->shouldReceive('option')->with('attribute', '')->andReturn('name,body');
        $this->assertEquals(['name', 'body'], $cmd->attributes());

        # ids
        $cmd->shouldReceive('option')->with('id', '')->andReturn('1,2');
        $this->assertEquals([1, 2], $cmd->ids());

        # locales
        $cmd->shouldReceive('option')->once()->with('locale', '')->andReturn('es_ES,foo');
        $this->assertEquals(['es_ES', 'foo'], $cmd->locales());
        $cmd->shouldReceive('option')->once()->with('locale', '')->andReturn('');
        $this->assertEquals(['es_ES'], $cmd->locales());

        # handle
        $cmd = m::mock(TranslateCommand::class . '[argument,items]');
        $cmd->shouldReceive('argument')->once()->with('action')->andReturn('items');
        $cmd->shouldReceive('items')->once()->andReturnSelf();
        $cmd->handle();
    }

    /**
     * @covers \Belt\Core\Commands\TranslateCommand::items
     */
    public function testItems()
    {
        $param = new StubTranslateCommandTestParam(['key' => 'foo', 'value' => 'original value']);

        $stub = new StubTranslateCommandTest();
        $stub->params = new Collection();
        $stub->params->put('foo', $param);

        $items = new Collection([$stub]);

        $qb = m::mock(Builder::class);
        $qb->shouldReceive('whereIn')->with('id', [1]);
        $qb->shouldReceive('get')->andReturn($items);

        Morph::shouldReceive('type2QB')->andReturn($qb);

        $cmd = m::mock(TranslateCommand::class . '[option, translate]');
        $cmd->shouldReceive('option')->with('type', '')->andReturn('foo');
        $cmd->shouldReceive('option')->with('limit')->andReturn(1);
        $cmd->shouldReceive('option')->with('id', '')->andReturn('1');

        $cmd->shouldReceive('translate')->once()->with($stub, 'name')->andReturnSelf();
        $cmd->shouldReceive('translate')->once()->with($stub, 'body')->andReturnSelf();
        $cmd->shouldReceive('translate')->once()->with($param, 'value')->andReturnSelf();

        $cmd->items();
    }

    /**
     * @covers \Belt\Core\Commands\TranslateCommand::translate
     */
    public function testTranslate()
    {
        // invalid attribute
        $stub = new StubTranslateCommandTest(['name' => 'foo', 'body' => 'original body']);
        $stub->syncOriginal();
        $cmd = m::mock(TranslateCommand::class . '[option]');
        $cmd->shouldReceive('option')->with('attribute', '')->andReturn('name,body');
        $this->assertNull($cmd->translate($stub, 'foo'));

        // empty source value
        $stub = new StubTranslateCommandTest(['name' => 'foo', 'body' => '']);
        $stub->syncOriginal();
        $cmd = m::mock(TranslateCommand::class . '[option]');
        $cmd->shouldReceive('option')->with('attribute', '')->andReturn('name,body');
        $this->assertNull($cmd->translate($stub, 'body'));

        // skip. translation already exists.
        $stub = new StubTranslateCommandTest(['name' => 'foo', 'body' => 'original body']);
        $stub->syncOriginal();
        $stub->translations = new Collection();
        $stub->translations->add(factory(Translation::class)->make([
            'locale' => 'es_ES',
            'translatable_column' => 'body',
            'value' => 'translated body',
        ]));
        $cmd = m::mock(TranslateCommand::class . '[option]');
        $cmd->shouldReceive('option')->with('locale', '')->andReturn('es_ES');
        $cmd->shouldReceive('option')->with('attribute', '')->andReturn('name,body');
        $cmd->shouldReceive('option')->with('force')->andReturn(false);
        $this->assertNull($cmd->translate($stub, 'body'));

        // translation already exists, but force it without queueing
        $stub = m::mock(StubTranslateCommandTest::class . '[saveTranslation]', [['name' => 'foo', 'body' => 'original body']]);
        $stub->shouldReceive('saveTranslation')->once()->with('body', 'better translated body', 'es_ES');
        $stub->syncOriginal();
        $stub->translations = new Collection();
        $stub->translations->add(factory(Translation::class)->make([
            'locale' => 'es_ES',
            'translatable_column' => 'body',
            'value' => 'translated body',
        ]));
        $cmd = m::mock(TranslateCommand::class . '[option,info]');
        $cmd->shouldReceive('option')->with('locale', '')->andReturn('es_ES');
        $cmd->shouldReceive('option')->with('attribute', '')->andReturn('name,body');
        $cmd->shouldReceive('option')->with('force')->andReturn(true);
        $cmd->shouldReceive('option')->with('queue')->andReturn(false);
        $cmd->shouldReceive('option')->with('debug')->andReturn(true);
        $cmd->shouldReceive('info')->once();
        Translate::shouldReceive('translate')->once()->with('original body', 'es_ES')->andReturn('better translated body');
        $this->assertNull($cmd->translate($stub, 'body'));

        // queue translation
        $stub = new StubTranslateCommandTest(['name' => 'foo', 'body' => 'original body']);
        $stub->syncOriginal();
        $stub->translations = new Collection();
        $cmd = m::mock(TranslateCommand::class . '[option]');
        $cmd->shouldReceive('option')->with('locale', '')->andReturn('es_ES');
        $cmd->shouldReceive('option')->with('attribute', '')->andReturn('name,body');
        $cmd->shouldReceive('option')->with('force')->andReturn(true);
        $cmd->shouldReceive('option')->with('queue')->andReturn(true);
        $cmd->translate($stub, 'body');
        Queue::assertPushed(TranslateValue::class, function ($job) use ($stub) {
            return $job->getItemType() === 'foo';
        });
    }

}

class StubTranslateCommandTest extends Model
{
    use HasConfig, Paramable, Translatable;

    /**
     * @return string
     */
    public function configPath()
    {
        return 'belt.StubTranslateCommandTest';
    }

    public function getMorphClass() {
        return 'foo';
    }
}

class StubTranslateCommandTestParam extends Model
{

}