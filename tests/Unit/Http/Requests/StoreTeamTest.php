<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Requests\StoreTeam;

class StoreTeamTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @covers \Belt\Core\Http\Requests\StoreTeam::rules
     */
    public function test()
    {

        $request = new StoreTeam();

        $this->assertNotEmpty($request->rules());
    }

}