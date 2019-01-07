<?php

use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Translation;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class TranslationTest extends BeltTestCase
{
    /**
     * @covers \Belt\Core\Translation::translatable
     */
    public function test()
    {
        $translation = factory(Translation::class)->make();

        $this->assertInstanceOf(    MorphTo::class, $translation->translatable());
    }

}