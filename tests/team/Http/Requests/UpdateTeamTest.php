<?php

use Ohio\Core\Team\Http\Requests\UpdateTeam;

class UpdateTeamTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\Team\Http\Requests\UpdateTeam::rules
     */
    public function test()
    {

        $request = new UpdateTeam();

        $this->assertNotEmpty($request->rules());
    }

}