<?php namespace Tests\Belt\Core\Feature\Api;

use Belt\Core\Tests;

class ApiIndexTest extends Tests\BeltTestCase
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