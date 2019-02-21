<?php namespace Tests\Belt\Core\Feature\Api;

use Belt\Core\Tests;

class ApiTeamsTest extends Tests\BeltTestCase
{

    public function test()
    {
        Queue::fake();

        $this->refreshDB();
        $this->actAsSuper();

        # index
        $response = $this->json('GET', '/api/v1/teams');
        $response->assertStatus(200);

        # store
        $response = $this->json('POST', '/api/v1/teams', [
            'name' => 'test',
        ]);
        $response->assertStatus(201);
        $response->assertJsonFragment(['name' => 'TEST']);
        $teamID = array_get($response->json(), 'id');

        # show
        $response = $this->json('GET', "/api/v1/teams/$teamID");
        $response->assertStatus(200);

        # update
        $this->json('PUT', "/api/v1/teams/$teamID", ['name' => 'updated']);
        $response = $this->json('GET', "/api/v1/teams/$teamID");
        $response->assertJson(['name' => 'UPDATED']);

        # delete
        $response = $this->json('DELETE', "/api/v1/teams/$teamID");
        $response->assertStatus(204);
        $response = $this->json('GET', "/api/v1/teams/$teamID");
        $response->assertStatus(404);
    }

}