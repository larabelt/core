<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Requests\StoreAbility;

class StoreAbilityTest extends \PHPUnit\Framework\TestCase
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