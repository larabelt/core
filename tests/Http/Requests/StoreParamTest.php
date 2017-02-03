<?php

use Ohio\Core\Http\Requests\StoreParam;

class StoreParamTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\Http\Requests\StoreParam::rules
     */
    public function test()
    {

        $request = new StoreParam();

        $this->assertNotEmpty($request->rules());
    }

}