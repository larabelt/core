<?php

use Belt\Core\Http\Requests\UpdateTranslation;

class UpdateTranslationTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @covers \Belt\Core\Http\Requests\UpdateTranslation::rules
     */
    public function test()
    {

        $request = new UpdateTranslation();

        //$this->assertNotEmpty($request->rules());
        $this->assertEquals([], $request->rules());
    }

}