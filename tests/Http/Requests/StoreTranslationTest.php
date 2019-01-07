<?php

use Belt\Core\Http\Requests\StoreTranslation;

class StoreTranslationTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @covers \Belt\Core\Http\Requests\StoreTranslation::rules
     */
    public function test()
    {

        $request = new StoreTranslation();

        $this->assertNotEmpty($request->rules());
    }

}