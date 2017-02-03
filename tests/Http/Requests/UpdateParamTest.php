<?php

use Ohio\Core\Http\Requests\UpdateParam;

class UpdateParamTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\Http\Requests\UpdateParam::rules
     */
    public function test()
    {

        $request = new UpdateParam();

        $this->assertNotEmpty($request->rules());
    }

}