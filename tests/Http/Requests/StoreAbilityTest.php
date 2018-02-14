<?php

use Belt\Core\Http\Requests\StoreAbility;

class StoreAbilityTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Belt\Core\Http\Requests\StoreAbility::rules
     */
    public function test()
    {

        $request = new StoreAbility();

        $this->assertNotEmpty($request->rules());
    }

}