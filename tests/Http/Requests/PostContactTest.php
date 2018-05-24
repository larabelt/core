<?php

use Belt\Core\Http\Requests\PostContact;

class PostContactTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @covers \Belt\Core\Http\Requests\PostContact::rules
     */
    public function test()
    {

        $request = new PostContact();

        $this->assertNotEmpty($request->rules());
    }

}