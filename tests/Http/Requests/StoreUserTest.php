<?php

use Belt\Core\Testing\BeltTestCase;
use Belt\Core\Http\Requests\StoreUser;

class StoreUserTest extends BeltTestCase
{

    /**
     * @covers \Belt\Core\Http\Requests\StoreUser::rules
     */
    public function test()
    {
        $request = new StoreUser();

        $this->assertNotEmpty($request->rules());
    }

}