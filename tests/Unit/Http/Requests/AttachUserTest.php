<?php namespace Tests\Belt\Core\Unit\Http;

use Belt\Core\Http\Requests\AttachUser;

class AttachUserTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @covers \Belt\Core\Http\Requests\AttachUser::rules
     */
    public function test()
    {

        $request = new AttachUser();

        $this->assertNotEmpty($request->rules());
    }

}