<?php

use Ohio\Core\Http\Requests\StoreTeam;

class StoreTeamTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\Http\Requests\StoreTeam::rules
     */
    public function test()
    {

        $request = new StoreTeam();

        $this->assertNotEmpty($request->rules());
    }

}