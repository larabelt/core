<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Requests\StoreUser;
use Tests\Belt\Core\BeltTestCase;

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