<?php

use Ohio\Core\Http\Requests\StoreUser;

class StoreUserTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\Http\Requests\StoreUser::rules
     */
    public function test()
    {

        $request = new StoreUser();

        $this->assertNotEmpty($request->rules());
    }

}