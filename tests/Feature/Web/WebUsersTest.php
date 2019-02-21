<?php namespace Tests\Belt\Core\Feature\Web;

use Belt\Core\Tests;

class WebUsersTest extends Tests\BeltTestCase
{

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        # signup
        $response = $this->json('GET', '/users/signup');
        $response->assertStatus(200);

        # welcome
        $response = $this->json('GET', '/users/welcome');
        $response->assertStatus(200);
    }

}