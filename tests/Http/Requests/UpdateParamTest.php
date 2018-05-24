<?php

use Belt\Core\Http\Requests\UpdateParam;

class UpdateParamTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @covers \Belt\Core\Http\Requests\UpdateParam::rules
     */
    public function test()
    {

        $request = new UpdateParam();

        $this->assertNotEmpty($request->rules());
    }

}