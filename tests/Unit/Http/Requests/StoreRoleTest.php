<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Requests\StoreRole;

class StoreRoleTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @covers \Belt\Core\Http\Requests\StoreRole::rules
     */
    public function test()
    {

        $request = new StoreRole();

        $this->assertNotEmpty($request->rules());
    }

}