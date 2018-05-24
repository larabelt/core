<?php

use Belt\Core\Http\Requests\UpdateTeam;

class UpdateTeamTest extends \PHPUnit\Framework\TestCase
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