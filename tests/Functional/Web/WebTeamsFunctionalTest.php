<?php

use Belt\Core\Testing;

class WebTeamsFunctionalTest extends Testing\BeltTestCase
{

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        # signup
        $response = $this->json('GET', '/teams/signup');
        $response->assertStatus(200);

        # welcome
        $response = $this->json('GET', '/teams/welcome');
        $response->assertStatus(200);
    }

}