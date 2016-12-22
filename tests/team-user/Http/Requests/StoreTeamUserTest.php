<?php

use Ohio\Core\TeamUser\Http\Requests\StoreTeamUser;

class StoreTeamUserTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers \Ohio\Core\TeamUser\Http\Requests\StoreTeamUser::rules
     */
    public function test()
    {

        $request = new StoreTeamUser();

        $this->assertNotEmpty($request->rules());
    }

}