<?php

use Belt\Core\Http\Requests\UpdateTeam;

class UpdateTeamTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Belt\Core\Http\Requests\UpdateTeam::rules
     */
    public function test()
    {

        $request = new UpdateTeam();

        $this->assertNotEmpty($request->rules());
    }

}