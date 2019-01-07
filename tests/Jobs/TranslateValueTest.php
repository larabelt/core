<?php

use Mockery as m;
use Belt\Core\Jobs\TranslateValue;
use Belt\Core\Testing;
use Belt\Core\Facades\TranslateFacade as Translate;
use Belt\Core\Facades\MorphFacade as Morph;

class TranslateValueTest extends Testing\BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Jobs\TranslateValue::__construct
     * @covers \Belt\Core\Jobs\TranslateValue::handle
     */
    public function test()
    {
        $item = m::mock(TranslateValueStub::class . '[saveTranslation]');
        $item->shouldReceive('saveTranslation')->once()->with('foo', 'barrito', 'es_ES');

        $job = new TranslateValue($item, 'foo', 'bar', 'es_ES', 'en_US');

        # __construct
        $this->assertEquals('foo', $job->attribute);
        $this->assertEquals('bar', $job->text);
        $this->assertEquals('es_ES', $job->target_locale);
        $this->assertEquals('en_US', $job->source_locale);

        # handle
        Translate::shouldReceive('translate')->with('bar', 'es_ES')->andReturn('barrito');
        Morph::shouldReceive('morph')->once()->with('test', 1)->andReturn($item);
        $job->handle();
    }

}

class TranslateValueStub extends Testing\BaseModelStub
{
    public $id = 1;

    public function getMorphClass()
    {
        return 'test';
    }
}