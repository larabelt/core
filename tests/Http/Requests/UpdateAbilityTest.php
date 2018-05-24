<?php

use Belt\Core\Http\Requests\UpdateAbility;

class UpdateAbilityTest extends \PHPUnit\Framework\TestCase
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