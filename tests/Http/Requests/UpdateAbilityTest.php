<?php

use Belt\Core\Http\Requests\UpdateAbility;

class UpdateAbilityTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Belt\Core\Http\Requests\UpdateAbility::rules
     */
    public function test()
    {

        $request = new UpdateAbility();

        $this->assertNotEmpty($request->rules());
    }

}