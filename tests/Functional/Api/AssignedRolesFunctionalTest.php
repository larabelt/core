<?php

use Belt\Core\Testing;

class AssignedRolesFunctionalTest extends Testing\BeltTestCase
{

    public function test()
    {
        $this->refreshDB();
        $this->actAsSuper();

        # index
        $response = $this->json('GET', '/api/v1/users/1/roles');
        $response->assertStatus(200);

        # attach
        $response = $this->json('POST', '/api/v1/users/1/roles', [
            'id' => 1,
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment(['id' => 1]);

        $response = $this->json('GET', "/api/v1/users/1/roles/1");
        $response->assertStatus(200);
        $response = $this->json('POST', '/api/v1/users/1/roles', [
            'id' => '',
        ]);
        $response->assertStatus(422);

        # show
        $response = $this->json('GET', "/api/v1/users/1/roles/1");
        $response->assertStatus(200);

        # detach
        $response = $this->json('DELETE', "/api/v1/users/1/roles/1");
        $response->assertStatus(204);
        $response = $this->json('GET', "/api/v1/users/1/roles/1");
        $response->assertStatus(404);
    }

}