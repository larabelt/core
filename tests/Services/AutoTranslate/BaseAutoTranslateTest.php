<?php

use Mockery as m;
use Belt\Core\Services\AutoTranslate\BaseAutoTranslate;
use Belt\Core\Testing;

class BaseAutoTranslateTest extends Testing\BeltTestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @covers \Belt\Core\Services\AutoTranslate\BaseAutoTranslate::split
     */
    public function test()
    {
        $service = new StubBaseAutoTranslateTest();

        $split = $service->split('I went to the store. I stuffed a chicken under my jacket. I ran.', 15);

        $this->assertEquals([
            'I went to the store.',
            'I stuffed a chicken under my jacket.',
            'I ran.',
        ], $split);
    }

}

class StubBaseAutoTranslateTest extends BaseAutoTranslate
{
    /**
     * @param $text
     * @param $target_locale
     * @param $source_locale
     */
    public function translate($text, $target_locale, $source_locale)
    {
        // doesn't matter
    }
}