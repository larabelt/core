<?php namespace Tests\Belt\Core\Feature\Web;

use Tests\Belt\Core;

class WebUsersTest extends \Tests\Belt\Core\BeltTestCase
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