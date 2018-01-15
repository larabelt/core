<?php

use Belt\Core\Testing;

class WebUsersFunctionalTest extends Testing\BeltTestCase
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