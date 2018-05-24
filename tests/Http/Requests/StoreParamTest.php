<?php

use Belt\Core\Http\Requests\StoreParam;

class StoreParamTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @covers \Belt\Core\Http\Requests\StoreParam::rules
     */
    public function test()
    {

        $request = new StoreParam();

        $this->assertNotEmpty($request->rules());
    }

}