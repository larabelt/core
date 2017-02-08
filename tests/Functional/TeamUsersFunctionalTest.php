<?php

use Ohio\Core\Testing;

class TeamUsersFunctionalTest extends Testing\OhioTestCase
{

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        # index
        $response = $this->json('GET', '/api/v1/teams/1/users');
        $response->assertStatus(200);

        # attach
        $response = $this->json('POST', '/api/v1/teams/1/users', [
            'id' => 2
        ]);
        $response->assertStatus(201);
        $response = $this->json('GET', "/api/v1/teams/1/users/2");
        $response->assertStatus(200);

        # show
        $response = $this->json('GET', "/api/v1/teams/1/users/2");
        $response->assertStatus(200);

        # detach
        $response = $this->json('DELETE', "/api/v1/teams/1/users/2");
        $response->assertStatus(204);
        $response = $this->json('GET', "/api/v1/teams/1/users/2");
        $response->assertStatus(404);
    }

}