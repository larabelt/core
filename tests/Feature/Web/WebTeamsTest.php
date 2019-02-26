<?php namespace Tests\Belt\Core\Feature\Web;

use Tests\Belt\Core;

class WebTeamsTest extends \Tests\Belt\Core\BeltTestCase
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