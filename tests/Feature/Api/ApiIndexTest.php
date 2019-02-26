<?php namespace Tests\Belt\Core\Feature\Api;

use Tests\Belt\Core;

class ApiIndexTest extends \Tests\Belt\Core\BeltTestCase
{

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        # index
        $response = $this->json('GET', '/api/v1/index');
        $response->assertStatus(200);
    }

}